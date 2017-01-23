<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Frequency extends Model
{
	 protected $casts = [
	        'content' => 'json'
	    ];

	 public function user() {
	 	return $this->belongsTo('App\User');
	 }

	public function getLastStatusDiff() {
        $last = $this->updated_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }
}
