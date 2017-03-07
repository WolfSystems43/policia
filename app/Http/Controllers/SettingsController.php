<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Mail;

use App\User;
use App\Mail\VerifyCode;

class SettingsController extends Controller
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
    
    public function settings() {
    	return view('settings');
    }

    public function saveSettings(Request $request) {
    	
    	$request->session()->put('dark', !is_null($request->dark_mode));

        $user = Auth::user();

        if(!is_null($request->email_enabled)) {
            $user->email_enabled = true;
        } else {
            $user->email_enabled = false;
        }

        $user->save();

    	return redirect(route('settings'))->with('status', 'Cambios guardados');
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
        $user->email_verified =  false;
        $user->email_code = null;
    	$user->save();

        if($user->validEmail()) {
            Mail::to($user)->send(new VerifyCode($user));  
        } else {
            $user->email = null;
            $user->save();
        }
        
        return redirect('/home')->with('status', trans('messages.mail_saved'));
    }

    public function verifyEmail(Request $request) {
        $user = Auth::user();

        // If already verified or has no email
        if($user->isVerified() || is_null($user->email)) {
            abort(403);
        }

        $this->validate($request, [
            'email_code' => 'required'
        ]);

        // Remove whitespace, since the digits are shown with a space
        // to the user when sent via email to make then easier to read.
        $code = preg_replace('/\s+/', '', $request->email_code);

        // Wrong code
        // Redirect home since it doesn't really matter the page the user
        // is redirected to as long as it's locked (pretty much every page)
        if($code != $user->emailCode()) {
            return redirect('/home')->with('status', 'Código incorrecto');
        }

        // The user has entered the correct code.
        $user->email_verified = true;
        $user->email_code = null;
        $user->save();

        return redirect('/home')->with('status', 'Correo verificado con éxito.');

    }
}
