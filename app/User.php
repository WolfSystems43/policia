<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use \Backpack\CRUD\CrudTrait, \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot()
    {
        parent::boot();

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'steamid', 'corp', 'rank', 'disabled', 'profile', 'shop', 'shop_reason', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['active_at'];

    protected $dontKeepRevisionOf = array(
        'active_at', 'remember_token', 'password'
    );

    public function specialties() {
        return $this->belongsToMany('App\Specialty')->withTimestamps();
    }

    public function ownedSpecialties() {
        return $this->hasMany('App\Specialty');
    }

    public function frequencies() {
        return $this->hasMany('App\Frecuency');
    }

    public function ticketsInvolved() {
        return $this->belongsToMany('App\Ticket');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }

    public function replies() {
        return $this->hasMany('App\Reply');
    }

    public function badges() {
        return $this->hasManyThrough('App\BadgeGrant', 'App\Badge');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('closed', 0);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClosed($query)
    {
        return $query->where('closed', 1);
    }

    public function getColor() {
        switch ($this->corp) {
            case 0:
                return "blue-grey darken-4";
                break;

            case 1:
                return "indigo";
                break;

            case 2: 
                return "color-gc";
                break;
            
            default:
                return "black";
                break;
        }
    }

    public function getCorpName() {
                switch ($this->corp) {
            case 0:
                return "Fuerzas de Seguridad del Estado";
                break;

            case 1:
                return "Cuerpo Nacional de Policía";
                break;

            case 2: 
                return "Guardia Civil";
                break;
            
            default:
                return "Sin cuerpo";
                break;
        }
    }

    public function getRankName() {
        if($this->rank == 0) {
            return "Civil";
        }

        if($this->corp == 0) {
            return "Recluta/Cadete";
        }

        if($this->rank == 12) {
            return "Comisario principal";
        }

        // Policía Nacional
        if($this->corp == 1) {
            switch ($this->rank) {
                case 1:
                    return "Recluta";
                    break;
                    
                case 2:
                    return "Agente";
                    break;
                    
                case 3:
                    return "Agente Segundo";
                    break;
                    
                case 4:
                    return "Agente Primero";
                    break;
                    
                case 5:
                    return "Suboficial";
                    break;
                    
                case 6:
                    return "Oficial en Prácticas";
                    break;
                    
                case 7:
                    return "Oficial";
                    break;
                    
                case 8:
                    return "Subinspector";
                    break;
                    
                case 9:
                    return "Inspector";
                    break;
                    
                case 10:
                    return "Inspector Jefe";
                    break;
                
                case 11:
                    return "Comisario";
                    break;

                default:
                    return "No especificado";
                    break;
                }
            }

        // Guardia Civil
        if($this->corp == 2) {
            switch ($this->rank) {
                case 1:
                    return "Cadete";
                    break;
                    
                case 2:
                    return "Guardia Civil";
                    break;
                    
                case 3:
                    return "Guardia Civil de 2ª";
                    break;
                    
                case 4:
                    return "Guardia Civil de 1ª Clase";
                    break;
                    
                case 5:
                    return "Cabo";
                    break;
                    
                case 6:
                    return "Sargento";
                    break;
                    
                case 7:
                    return "Teniente";
                    break;
                    
                case 8:
                    return "Capitán";
                    break;
                    
                case 9:
                    return "Comandante";
                    break;
                    
                case 10:
                    return "Teniente Coronel";
                    break;
                
                case 11:
                    return "Coronel";
                    break;

                default:
                    return "No especificado";
                    break;
                }
            }

            return "Sin rango";
        
    }

    public function getRankImage() {
        if($this->rank == 0) {
            return "/img/divisas/cnpgc.png";
        }

        if($this->corp == 0) {
            return "/img/divisas/cnpgc.png";
        }

        // Policía Nacional
        if($this->corp == 1) {
            return "/img/divisas/cnp/". $this->rank .".png";
        }

        
        // Guardia Civil
        if($this->corp == 2) {
            return "/img/divisas/gc/". $this->rank .".png";
        }

        return "/img/divisas/cnpgc.png";
        
    }

    public function getCorpImage() {
        if($this->corp == 1) {
            return "/img/divisas/cnp.png";
        }
        if($this->corp == 2) {
            return "/img/divisas/gc.png";
        }
        return "/img/divisas/cnpgc.png";
    }

    public function isAdmin() {
        return $this->admin;
    }

    // Míniom Inspector/Comandante o admin
    public function isMando() {
        return $this->rank >=9 || $this->isAdmin();
    }

    public function isDisabled() {
        return $this->disabled;
    }

    public function isIA() {
        if(is_null(\App\Specialty::find(6))) {
            return false;
        }
        return \App\Specialty::find(6)->user == $this || $this->isAdmin();
    }

    public function hasMail() {
        return ! is_null($this->email);
    }

    public function getCreatedDiff() {
        $last = $this->created_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }

    public function getLastUpdatedDiff() {
        $last = $this->updated_at;

        $dt = Carbon::parse($last);

        Carbon::setLocale('es');
        return $dt->diffForHumans();
    }
}
