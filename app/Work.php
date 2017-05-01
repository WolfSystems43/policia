<?php

namespace App;

use App\Scopes\OngoingScope;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{

    protected $hidden = [
        'end_at', 'end_reason', 'updated_at', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OngoingScope());
    }

    public function isShort()
    {
        return $this->created_at->addMinutes(20)->isFuture();
    }

}
