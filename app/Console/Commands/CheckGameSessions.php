<?php

namespace App\Console\Commands;

use App\GameSession;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckGameSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamesessions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Game Sessions and kick offline players';

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
        $gameSessions = GameSession::all();
        $gameSessions->each(function ($gameSession) {
            $this->info("Comprobación sesión #".$gameSession->id." del servidor #".$gameSession->server->id);
            $online = $gameSession->server->isOnline();
            if($online) {
                $this->info("Servidor online, comprobando usuarios...");
                $gameSession->works->each(function ($work) use ($online) {
                    if(! $work->gameSession->server->checkName($work->user->name)) {
                        // User is not online. End the work, mark it as not online. If less than 20 minutes, cancel it completely.
                        if($work->created_at->addMinutes(20)->isFuture()) {
                            $work->end_reason = "cancel_offline";
                            $this->info("Usuario #" . $work->user->id . " offline, menos de 20 minutos on, cancelando");
                        } else {
                            $work->end_reason = "offline";
                            $this->info("Usuario #" . $work->user->id . " offline, más de 20 minutos on");
                        }
                        $work->end_at = Carbon::now();
                    }
                    if($work->user->isDisabled()) {
                        $work->end_reason = "kick";
                        $work->end_at = Carbon::now();
                    }
                    $work->save();
                });
            } else {
                $this->info("Saltando servidor, offline.");
            }
        });
    }
}
