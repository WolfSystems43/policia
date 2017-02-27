<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use \Backpack\CRUD\CrudTrait, \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'description', 'level', 'visible', 'image',
    ];
}
