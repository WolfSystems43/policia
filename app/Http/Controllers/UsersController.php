<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function users() {
    	$users = User::where('disabled', 0)->orderBy('rank', 'desc')->get();
    	// TODO last updated
    	return view('users.list')->with('users', $users);
    }
}
