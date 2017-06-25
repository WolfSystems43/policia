<?php

namespace App\Http\Controllers;

use App\Mail\ResignationAccepted;
use Illuminate\Http\Request;

use Auth;
use Gate;
use Mail;


use Carbon\Carbon;

use App\Ticket;
use App\User;
use App\Reply;
use App\Specialty;
use App\Mail\RepliedTicket;
use App\Mail\TicketCreated;

class TicketController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function newTicketResign() {
        if(Auth::user()->locked) {
            abort(403);
        }
        return view('tickets.resign');
    }

    public function newTicket($id = null) {

        if(!is_null($id)) {
            $user = User::findOrFail($id);
        } else {
            $user = null;
        }

        return view('tickets.new')->with('user', $user);
    }

    public function newTicketPost(Request $request, $id = null) {

    	$this->validate($request, [
    		'title' => 'required|max:100|min:15',
    		'body' => 'required|max:1000|min:20',
    		'implicated' => 'required|max:200',
       	],[
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede tener más de 100 caracteres.',
            'title.min' => 'El título debe tener como mínimo 15 caracteres.',
            'body.required' => 'La descripción es obligatoria.',
            'body.max' => 'La descripción no puede tener más de 100 caracteres.',
            'body.min' => 'La descripción debe tener como mínimo 15 caracteres.',
		    'implicated.required' => 'Selecciona al menos una persona.',
		]);

    	$ticket = new Ticket;
    	$ticket->type = 1;
    	$ticket->title = $request->title;
    	$ticket->body = $request->body;

    	$implicated = $request->implicated;

    	$i = 0;
    	foreach ($request->implicated as $value) {
    		$value = intval($value);
    		if($value == 0) {
    			abort(500, "Error en usuarios implicados");
    		}
    		$implicated[$i] = $value;
    		$i++;
    	}


    	if (isset($request->anonymous)) {
    		$ticket->anonymous = true;
    	}

    	Auth::user()->tickets()->save($ticket);
    	$ticket->usersInvolved()->attach($implicated);
        
        // Mail logic

        // Send mail to Admins if they have notifications enabled
        foreach (User::all()->where('admin', 1) as $user) {
            if($user->emailEnabled()) {
                if($user->validEmail()) {
                    Mail::to($user)->send(new TicketCreated($ticket));   
                }
            }
        }

        // Send mail to IA boss if exists

        $iABoss = null;

        if(!is_null(Specialty::find(6))) {
            $iABoss = Specialty::find(6)->user;
        }
        
        if (!is_null($iABoss)) {
            if ($iABoss->emailEnabled() && ! $iABoss->isAdmin()) {
                if($iABoss->validEmail()) {
                    Mail::to($iABoss)->send(new TicketCreated($ticket));   
                }
            }
        }


        return redirect(route('ticket', ['id' => $ticket->id]));
    }

    public function newTicketResignPost(Request $request, $id = null) {

        if(Auth::user()->isWorking()) {
            abort(403);
        }

        $this->validate($request, [
            'body' => 'required|max:1000|min:20',
            'check1' => 'accepted',
            'check2' => 'accepted',
            'check3' => 'accepted',
        ],[
            'body.required' => 'La descripción es obligatoria.',
            'body.max' => 'La descripción no puede tener más de 100 caracteres.',
            'body.min' => 'La descripción debe tener como mínimo 15 caracteres.',
            'check1.accepted' => 'Acepta las condiciones',
            'check2.accepted' => 'Acepta las condiciones',
            'check3.accepted' => 'Acepta las condiciones',
        ]);

        $user = Auth::user();

        $ticket = new Ticket;
        $ticket->type = 2;
        $ticket->title = "Dimisión " . Auth::user()->name;
        $body = $request->body;
        $body = $body . "\n\n--------------------\n\n(Información generada automáticamente:)";
        $body = $body . "\nCuerpo: " . Auth::user()->getCorpName();
        $body = $body . "\nRango: " . Auth::user()->getRankName();
        if ($user->isAdmin()) {
            $body = $body . "\nAdministrador del panel";
        }
        $body = $body . "\nEspecialidades:";
        $count = 0;
        foreach ($user->specialties as $specialty) {
            $body = $body . " " . $specialty->acronym;
            $count++;
        }
        if($count == 0) {
            $body = $body . " ninguna";
        }
        $body = $body . "\nMedallas, licencias y diplomas:";
        $count = 0;
        foreach ($user->grants as $grant) {
            $body = $body . " " . $grant->badge->name;
            $count++;
        }
        if($count == 0) {
            $body = $body . " ninguna";
        }
        $body = $body . "\nFecha de registro: " . $user->created_at->format("d/m/Y");
        $ticket->body = $body;
        $ticket->anonymous = false;

        Auth::user()->tickets()->save($ticket);

        // Si el usuario pertenece a asuntos internos, echarle del grupo
        if(! is_null(\App\Specialty::find(6))) {
            $ai = Specialty::findOrFail(6);
            // Si la persona es el mando de Asuntos Internos quitarle el mando
            if($ai->user->id == Auth::user()->id) {
                $ai->user_id = null;
                $ai->save();
            }
            $user->specialties()->detach(6);
        }

        // Bloquear al usuario para que no pueda entrar de servicio ni editar el panel de admin
        $user = Auth::user();
        $user->locked = true;
        $user->admin = false;
        $user->timestamps = false;
        $user->save();
        $user->timestamps = true;


        // Mail logic

        // Send mail to Admins if they have notifications enabled
        foreach (User::all()->where('admin', 1) as $user) {
            if($user->emailEnabled()) {
                if($user->validEmail()) {
                    Mail::to($user)->send(new TicketCreated($ticket));
                }
            }
        }

        // Send mail to IA boss if exists

        $iABoss = null;

        if(!is_null(Specialty::find(6))) {
            $iABoss = Specialty::find(6)->user;
        }

        if (!is_null($iABoss)) {
            if ($iABoss->emailEnabled() && ! $iABoss->isAdmin()) {
                if($iABoss->validEmail()) {
                    Mail::to($iABoss)->send(new TicketCreated($ticket));
                }
            }
        }


        return redirect(route('ticket', ['id' => $ticket->id]));
    }

    public function viewTicket($id) {

    	$ticket = Ticket::findOrFail($id);

        if (Gate::denies('view-ticket', $ticket)) {
            abort(403);
        }


    	return view('tickets.view')->with('ticket', $ticket);
    }

    public function newReply(Request $request, $id) {
        $this->validate($request, [
            'body' => 'required|max:500|min:15',
        ],[
            'body.required' => 'El contenido es obligatorio.',
            'body.max' => 'La respuesta no puede tener más de 1000 caracteres.',
            'body.min' => 'La respuesta debe tener como mínimo 15 caracteres.',
        ]);

        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if($request->body == "" || is_null($request->body)) {
            abort(500, "Vacío");
        } 



        $reply = new Reply;
        $reply->body = $request->body;

        if($ticket->user == $user) {
            $reply->staff = false;
        } else {
            if($user->isIA()) {
                $reply->staff = true;
            }
        }

        $reply->user_id = Auth::user()->id;
        $ticket->replies()->save($reply);

        if($ticket->user != $user) {
            if($ticket->user->validEmail()) {
                Mail::to($ticket->user)->send(new RepliedTicket($reply));   
            }
            
        }

        return redirect(route('ticket', ['id' => $ticket->id]));
    }

    public function closeTicket(Request $request, $id) {

        $ticket = Ticket::findOrFail($id);

        $this->validate($request, [
            'result' => 'required|integer|max:3|min:0',
        ]);

        if (Gate::denies('close-ticket', $ticket)) {
            abort(403);
        }

        if($ticket->closed) {
            abort(500, 'El Ticket ya está cerrado');
        }

        $reply = new Reply;
        $reply->body = "El ticket ha sido cerrado. No se permiten nuevas respuestas.";
        $reply->system = true;
        $reply->staff = true;

        $reply->user_id = Auth::user()->id;
        $ticket->replies()->save($reply);
        $ticket->closed = true;
        $ticket->closed_at = Carbon::now();
        $ticket->result = $request->result;
        $ticket->save();

        // Si es una dimisión desbloquear cuenta al cerrar
        if($ticket->type === 2) {
            $user = $ticket->user;

            // Si ha sido aceptada, sacar al usuario de la web.
            if($request->input('result') == 2) {
                $user->admin = 0;
                $user->rank = 0;
                $user->corp = 0;
                $user->grants()->delete();
                $user->specialties()->sync(null);
                $user->disabled = 1;
                Mail::to($user)->send(new ResignationAccepted($user));
            }
            // En cualquier caso, desbloquear usuario.
            $user->locked = false;

            $user->timestamps = false;
            $user->save();
            $user->timestamps = true;
        }

        return redirect(route('ticket', ['id' => $ticket->id]));
    }

    public function openTicket(Request $request, $id) {

        $ticket = Ticket::findOrFail($id);

        if (Gate::denies('close-ticket', $ticket)) {
            abort(403);
        }

        if(!$ticket->closed) {
            abort(500, 'El Ticket ya está abierto');
        }

        $reply = new Reply;
        $reply->body = "El ticket ha sido reabierto. Se permiten nuevas respuestas.";
        $reply->system = true;
        $reply->staff = true;

        $reply->user_id = Auth::user()->id;
        $ticket->replies()->save($reply);
        $ticket->closed = false;
        $ticket->result = 0;
        $ticket->save();

        return redirect(route('ticket', ['id' => $ticket->id]));
    }

    public function listTickets() {
        if (Gate::denies('admin-tickets')) {
            abort(403);
        }

        $tickets = Ticket::orderBy('created_at', 'asc')->where('closed', 0)->paginate(15);
        $title = "Casos abiertos";
        return view('tickets.list')->with('tickets', $tickets)->with('title', $title);

    }

    public function listClosedTickets() {

        if (Gate::denies('admin-tickets')) {
            abort(403);
        }

        $tickets = Ticket::orderBy('created_at', 'desc')->where('closed', 1)->paginate(15);
        $title = "Casos cerrados";
        return view('tickets.list')->with('tickets', $tickets)->with('title', $title);

    }

    public function listUserTickets() {
        $user = Auth::user();

        $tickets = $user->tickets()->where('hidden', 0)->orderBy('created_at', 'desc')->paginate(15);

        $title = "Tus tickets";
        return view('tickets.list')->with('tickets', $tickets)->with('title', $title);
    }
}
