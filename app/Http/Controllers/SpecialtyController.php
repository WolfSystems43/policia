<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Specialty;

class SpecialtyController extends Controller
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

    public function listSpecialties() {
        $specialties = Specialty::all();
        return view('specialties.list')->with('specialties', $specialties);
    }

    public function view($id) {
    	$specialty = Specialty::findOrFail($id);
    	return view('specialties.view')->with('specialty', $specialty);
    }
}
