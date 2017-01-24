<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings() {
    	return view('settings');
    }

    public function saveSettings(Request $request) {
    	
    	$request->session()->put('dark', !is_null($request->dark_mode));

    	return redirect(route('settings'));
    }
}
