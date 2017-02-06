<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Post extends Model
{
    use SoftDeletes;
    use \Backpack\CRUD\CrudTrait, \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'announcement', 'user_id',
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function isNew() {
    	$dt = $this->created_at;
    	$dt->addDays(2);
    	return $dt->isFuture();
    }

    public function getCreatedDiff() {
        $last = $this->created_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }

}
