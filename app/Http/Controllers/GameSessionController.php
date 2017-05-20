<?php

namespace App\Http\Controllers;

use App\Frequency;
use App\GameSession;
use App\Server;
use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GameSessionController extends Controller
{
    public function index()
    {
        $servers = Server::where('disabled', 0)->get();
        if (Auth::user()->isWorking()) {
            $frequencies = [];
            $freq = Auth::user()->getWork()->gameSession->frequencies()->latest()->first();
            if(! is_null($freq)) {
                $frequencies = collect($freq->content);
            }
            return view('sessions.session')->with('servers', $servers)->with('frequencies', collect($frequencies));

        }
        return view('sessions.index')->with('servers', $servers);
    }

    public function startWork(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|min:1'
        ]);

        $gameSession = GameSession::findOrFail($request->id);

        if(Gate::denies('start-work', $gameSession)) {
            abort(403);
        }

        if (! $this->checkName($gameSession, Auth::user()->name)) {
            return redirect(route('start-work'))->with('status', 'No detectamos que estés conectado al servidor. Inténtalo de nuevo en un minuto.')
                ->with('name_error', true);
        }

        $work = new Work();
        $work->game_session_id = $gameSession->id;
        $work->user_id = Auth::user()->id;
        $work->save();

        return redirect(route('start-work'))->with('status','Has entrado al servicio');
    }

    public function endWork(Request $request)
    {
        $user = Auth::user();
        $work = $user->getWork();
        $work->end_at = Carbon::now();

        // Check if work is at least 20 minutes old
        if($work->created_at->addMinutes(20)->isFuture()) {
            $work->end_reason = "cancel_user";
        } else {
            $work->end_reason = "user";
        }

        $work->save();

        return redirect(route('start-work'))->with('status', 'Has salido del servicio');
    }

    // Check if the name is online
    public function checkName($gameSession, $name)
    {
        $players = collect($gameSession->server->getQuery()->get('players'));
        $players_p = $players->mapWithKeys(function($item) {
            $pName = trim(preg_replace('~\h*\[(?:[^][]+|(?R))*+]\h*~', '', $item['name']));
           return [$pName => $pName];
        });
        return ! is_null($players_p->get(Auth::user()->name));
    }

    public function sessionApi()
    {
        if(! Auth::user()->isWorking()) {
            abort(404);
        }
        return Auth::user()->getWork()->gameSession->load(['server', 'works.user', 'works.user.visibleSpecialties']);
    }

    public function sessionApiKick(Request $request)
    {
        if(! Auth::user()->isMando()) {
            abort(403);
        }

        $work = Work::findOrFail($request->work_id);

        $work->end_reason = "kick";
        $work->end_at = Carbon::now();
        $work->save();


    }
}
