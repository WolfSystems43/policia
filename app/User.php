<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function specialties() {
        return $this->belongsToMany('App\Specialty')->withTimestamps();
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
                    return "Agente segundo";
                    break;
                    
                case 4:
                    return "Agente primero";
                    break;
                    
                case 5:
                    return "Suboficial";
                    break;
                    
                case 6:
                    return "Oficial en prácticas";
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
                    return "Inspector jefe";
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
                    return "Agente";
                    break;
                    
                case 3:
                    return "Agente segundo";
                    break;
                    
                case 4:
                    return "Agente primero";
                    break;
                    
                case 5:
                    return "Cabo";
                    break;
                    
                case 6:
                    return "Cabo primero";
                    break;
                    
                case 7:
                    return "Cabo mayor";
                    break;
                    
                case 8:
                    return "Sargento";
                    break;
                    
                case 9:
                    return "Teniente";
                    break;
                    
                case 10:
                    return "Coronel";
                    break;
                
                case 11:
                    return "Comisario";
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
}
