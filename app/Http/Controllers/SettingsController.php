<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;

class SettingsController extends Controller
{
    public function settings() {
    	return view('settings');
    }

    public function saveSettings(Request $request) {
    	
    	$request->session()->put('dark', !is_null($request->dark_mode));

    	return redirect(route('settings'));
    }

    public function emailSettings(Request $request) {
    	$this->validate($request, [
    		'email' => 'required|email|unique:users|confirmed'
    	],[
		    'email.required' => 'Necesitamos saber tu dirección de correo.',
		    'email.email' => 'Correo inválido.',
		    'email.unique' => 'Ese correo ya está siendo usado por alguien más.',
		    'email.confirmed' => 'El correo no era el mismo que el primero.'
		]);

    	$user = Auth::user();
    	$user->email = $request->email;
    	$user->save();
    	return redirect(route('home'))->with('status', 'Correo guardado correctamente.');
    }
}
