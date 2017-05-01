<?php

namespace App\Console\Commands;

use App\GameSession;
use App\Scopes\PastSessionScope;
use App\Server;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateGameSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamesessions:update {start}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Server::where('disabled', 0)->get()->each(function ($server) {
            $server->gameSessions()->withoutGlobalScopes([PastSessionScope::class])->where('closed', 0)
                ->where('server_id', $server->id)->each(function ($gameSession) {
                    $this->info("Cerrando #".$gameSession->id);
                    // Close the session
                    $gameSession->closed = true;
                    $gameSession->save();
                    // End all works
                    $gameSession->works->each(function ($work) {

                        $work->end_at = Carbon::now();

                        // Check if the work is shorter than 20 minutes
                        if ($work->isShort()) {
                            $work->end_reason = 'cancel_end';
                        } else {
                            $work->end_reason = 'end';
                        }

                        $work->save();
                        $this->info("Terminando trabajo #".$work->id);
                    });
                });

            // Create new session for the server
            $gameSession = new GameSession();

            $date = Carbon::create(null, null, null, $this->argument('start'), 0, 0);
            $gameSession->start_at = $date;

            // Session should end 6 hours after it started
            $gameSession->end_at = $date->addHours(6);

            $server->gameSessions()->save($gameSession);

            Artisan::call('frequencies:regenerate', [
                'gamesession' => $gameSession->id
            ]);

            $this->info("Generada sesión #".$gameSession->id." con frecuencias para servidor #".$server->id);
        });



    }
}
