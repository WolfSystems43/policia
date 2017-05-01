<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Auth;

use App\Ticket;
use App\Post;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // 
    public function index()
    {
        $links = [
            ['Multas y sanciones', 'multas', 'euro_symbol'], 
            ['Normativa', 'normativa-interna', 'class'], 
            ['Zonas de Asignación', 'zonas-de-asignacion', 'layers'],
            ['Lista del personal', 'lista', 'group'], 
            ['Calendario', 'calendario', 'event'], 
            ['Otros enlaces', 'enlaces', 'link'],
            ['Condecoraciones', 'condecoraciones', 'card_giftcard'],
        ];

        $user = User::findOrFail(Auth::user()->id);

        $tickets = $user->tickets()->where('closed', 0)->get();

        $tickets_open = Ticket::where('closed', 0)->count();

        $posts = Post::orderBy('created_at', 'desc')->take(4)->get();

        return view('home')->with('links', $links)->with('tickets', $tickets)->with('tickets_open', $tickets_open)->with('posts', $posts);
    }

    public function about() {
        return view('about');
    }
}
