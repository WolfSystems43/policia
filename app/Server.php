<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Server extends Model
{

    protected $hidden = [
      'disabled', 'created_at', 'updated_at'
    ];

    public function gameSessions()
    {
        return $this->hasMany(GameSession::class);
    }

    public function getQuery()
    {
        if(Cache::has('server-'. $this->id .'-query')) {
            return Cache::get('server-'. $this->id .'-query');
        } else {
            $count = 0;
            $online = false;
            $query = null;
            do {
                // Define the servers you wish you query
                $gservers = [
                    [
                        'type'    => 'Armedassault3',
                        'host'    => $this->address .':'. $this->port,
                    ]
                ];

                $GameQ = new \GameQ\GameQ(); // or $GameQ = \GameQ\GameQ::factory();
                $GameQ->addServers($gservers);
                $GameQ->setOption('timeout', 5); // seconds
                $query = collect(collect($GameQ->process())->first());
                if($query->get('gq_online')) {
                    $online = true;
                    Cache::put('server-'. $this->id .'-query', $query, 3);
                    return $query;
                }
                $count++;
            }while(! $online && $count <= 3);

            return $query;
        }
    }

    public function isOnline()
    {
        return $this->getQuery()->get('gq_online');
    }

    // Check if the name is online
    public function checkName($name)
    {
        if(! $this->isOnline()) {
            return false;
        }

        $players = collect($this->getQuery()->get('players'));
        $players_p = $players->mapWithKeys(function($item) {
            $pName = trim(preg_replace('~\h*\[(?:[^][]+|(?R))*+]\h*~', '', $item['name']));
            return [$pName => $pName];
        });
        return ! is_null($players_p->get($name));
    }
}
