<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Gate;
use App\Frequency;

class FrequencyController extends Controller
{   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generate() {

        if (Gate::denies('regenerate-frequencies')) {
            abort(403, 'No tienes permiso para regenerar frecuencias');
        }

    	$frequency = new Frequency;
    	$freq = [];
    	$names = ["Alpha", "Bravo", "Charly", "Delta", "Eco", "Foxtrot", "Golf", "Hotel",
    	"India", "Juliet", "Kilo", "Lima", "Mike", "November", "Oscar", "Papa", "Quebec", 
    	"Romeo", "Sierra", "Tango", "Uniform", "Victor", "Whisky", "X-Ray", "Yankee", "Zulu",
    	"EMS", "Seguridad Privada", "H-50", "Metacóptero", "Z-10", "Z-11", "Z-20", "Z-21", "Z-30", "Z-31", "UPR", "Alpha 100", "Bravo 100",
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
    	$frequency->user_id = Auth::user()->id;
    	$frequency->save();
    	return redirect(route('frequencies'));
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freq = Frequency::orderBy('created_at', 'desc')->first();
        $frequencies = collect($freq->content);

        $user = $freq->author;

        return view('frequencies.list')->with('frequencies', $frequencies)->with('frequency', $freq);
    }

    public function emsApi($key) {
        if(!($key == env('APP_EMS', ""))) {
            abort(403);
        }

        $freq = Frequency::orderBy('created_at', 'desc')->first();
        $ems = collect($freq->content)->where(0, 'EMS')->first();
        return $ems[1];
    }

}
