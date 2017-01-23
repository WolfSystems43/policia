<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Specialty extends Model
{
    use \Backpack\CRUD\CrudTrait, \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot()
    {
        parent::boot();
    }


    protected $fillable = [
        'name', 'acronym', 'description', 'message', 'secret', 'user_id', 'message'
    ];

    public function users() {
    	return $this->belongsToMany('App\User')->withTimeStamps();
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function getLastUpdatedDiff() {
        $last = $this->updated_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }
}
