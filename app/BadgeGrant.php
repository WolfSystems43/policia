<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BadgeGrant extends Model
{
    use \Backpack\CRUD\CrudTrait, \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'badge_id', 'author_id', 'message',
    ];

	public function badge() {
		return $this->belongsTo('App\Badge');
	}

    public function user() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function author() {
    	return $this->hasOne('App\User', 'id', 'author_id');
    }
}
