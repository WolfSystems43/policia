<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use App\Frequency;

class RegenerateFrequencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'frequencies:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate frequencies';

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
        Log::info('***** REGENERANDO FRECUENCIAS ******');

        $frequency = new Frequency;
        $freq = [];
        $names = ["Alpha", "Bravo", "Charly", "Delta", "Eco", "Foxtrot", "Golf", "Hotel",
        "India", "Juliet", "Kilo", "Lima", "Mike", "November", "Oscar", "Papa", "Quebec", 
        "Romeo", "Sierra", "Tango", "Uniform", "Victor", "Whisky", "X-Ray", "Yankee", "Zulu",
        "EMS", "Seguridad Privada", "Asignación", "H-50", "Metacóptero", "Z-10", "Z-11", "Z-20", "Z-21", "Z-30", "Z-31", "Z-40", "UPR", "Alpha 100", "Bravo 100",
        "Charly 100", "Delta 100", "Echo 100", "Foxtrot 100", "UIP/GRS", "ATGC 10", "ATGC 20", 
        "Intervención", "Marítima"];

        for ($i=0; $i < count($names); $i++) {
            
            
            $num = rand(1000, 9999);
            if ($num % 10 == 0) {
                $num = $num/10 . ".0";
            } else {
                $num = "" . $num / 10;
            }
            
            $freq[$i] = [$names[$i], $num];
        }
        $frequency->content = $freq;
        $frequency->user_id = 1;
        $frequency->save();
    }
}
