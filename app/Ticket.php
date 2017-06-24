<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Ticket extends Model
{
    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function usersInvolved() {
    	return $this->belongsToMany('App\User');
    }

    public function replies() {
        return $this->hasMany('App\Reply');
    }

    public function getTypeName() {
    	$text = "Ticket";
    	switch ($this->type) {
    		case 1:
    			$text = "Queja interna";
    			break;
            case 2:
                $text = "Dimisión";
                break;
    		
    		default:
    			$text = "Ticket";
    			break;
    	}

    	return $text;
    }

    public function getLastReply() {
        return $this->replies()->orderBy('created_at', 'desc')->get()->first();
    }

    public function getStatus() {
        switch ($this->result) {
            case 1:
                return ['text' => 'Solucionado', 'icon' => 'check_circle'];
                break;
            case 2:
                return ['text' => 'Aceptado', 'icon' => 'check_circle'];
                break;
            case 3:
                return ['text' => 'Rechazado', 'icon' => 'block'];
                break;
        }
        if ($this->closed) {
            return ['text' => 'Cerrado', 'icon' => 'lock'];
        }

        return ['text' => 'En proceso', 'icon' => 'access_time'];
    }

    public function getCreatedDiff() {
        $created = $this->created_at;

        $dt = Carbon::parse($created);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }

    public function getClosedDiff() {
        $closed = $this->closed_at;
        if(is_null($closed)) {
            return "";
        }

        $dt = Carbon::parse($closed);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }

}
