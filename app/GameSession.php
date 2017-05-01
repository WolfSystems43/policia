<?php

namespace App;

use App\Scopes\PastSessionScope;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PastSessionScope());
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_closed', 'name', 'freq'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_at',
        'end_at'
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function frequencies()
    {
        return $this->hasMany(\App\Frequency::class);
    }

    public function getName()
    {
        return $this->start_at->format('H:i').' a '. $this->end_at->format('H:i');
    }

    public function getNameAttribute()
    {
        return $this->getName();
    }

    public function getIsClosedAttribute()
    {
        return $this->isClosed();
    }

    public function isClosed()
    {
        return false;
        return $this->end_at->subMinutes(10)->isPast();
    }

    public function getFreqAttribute()
    {
        return $this->frequencies()->latest()->first();
    }
}
