<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Reply extends Model
{

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function ticket() {
    	return $this->belongsTo('App\Ticket');
    }

    public function getCreatedDiff() {
        $last = $this->created_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }

}
