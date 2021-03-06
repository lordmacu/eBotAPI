<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\Map;
use Reflex\Database\Models\Season;
use Reflex\Database\Models\Server;
use Reflex\Database\Models\Team;
use Reflex\Database\Traits\MatchStatusTrait;
use Reflex\Socket\Socket;

class Match extends Model
{
    use MatchStatusTrait;

    protected $table = 'matchs';

    protected $fillable = [
        'ip', 'server_id', 'season_id', 'team_a',
        'team_a_flag', 'team_a_name', 'team_b',
        'team_b_flag', 'team_b_name', 'status',
        'is_paused', 'score_a', 'score_b', 'max_round',
        'rules', 'overtime_startmoney', 'overtime_max_round',
        'config_full_score', 'config_ot', 'config_streamer',
        'config_knife_round', 'config_switch_auto',
        'config_auto_change_password', 'config_password',
        'config_heatmap', 'config_authkey', 'enable',
        'map_selection_mode', 'ingame_enable', 'current_map',
        'force_zoom_match', 'identifier_id', 'startdate',
        'auto_start', 'auto_start_time'
    ];

    protected $appends = ['running', 'connect', 'gotv_connect'];

    /**
     * Constants for Status
     */
    const STATUS_UNKNOWN = -1;
    const STATUS_NOT_STARTED = 0;
    const STATUS_STARTING = 1;
    const STATUS_KNIFE_WARMUP = 2;
    const STATUS_KNIFE_ROUND = 3;
    const STATUS_KNIFE_FINISHED = 4;
    const STATUS_FIRST_SIDE_WARMUP = 5;
    const STATUS_FIRST_SIDE = 6;
    const STATUS_SECOND_SIDE_WARMUP = 7;
    const STATUS_SECOND_SIDE = 8;
    const STATUS_OT_FIRST_SIDE_WARMUP = 9;
    const STATUS_OT_FIRST_SIDE = 10;
    const STATUS_OT_SECOND_SIDE_WARMUP = 11;
    const STATUS_OT_SECOND_SIDE = 12;
    const STATUS_FINISHED = 13;
    const STATUS_ARCHIVED = 14;

    public function server()
    {
        return $this->hasOne(Server::class, 'id', 'server_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function teamA()
    {
        return $this->hasOne(Team::class, 'id', 'team_a');
    }

    public function teamB()
    {
        return $this->hasOne(Team::class, 'id', 'team_b');
    }

    public function map()
    {
        return $this->hasOne(Map::class, 'id', 'current_map');
    }

    public function getRunningAttribute()
    {
        return ($this->status > 1 && $this->status < 13);
    }

    public function getConnectAttribute()
    {
        if (is_null($this->server)) return null;
        return "connect {$this->server->ip}" . (!empty($this->config_password) ? ";; password {$this->config_password}" : '');
    }

    public function getGotvConnectAttribute()
    {
        if (is_null($this->server)) return null;
        return "connect {$this->server->tv_ip}";
    }

    public function startMatch()
    {
        $this->status = self::STATUS_STARTING;
        $this->enable = 1;
        $this->save();
    }

    public function restartMatch()
    {
        $this->stopMatch();
        $this->resetMatch();
        sleep(3);
        $this->startMatch();
    }

    public function resetMatch()
    {
        $this->score_a = 0;
        $this->score_b = 0;
        $this->status = 0;
        $this->enable = 0;
        $this->ingame_enable = null;
        $this->is_paused = null;
        $this->save();

        $this->map->score_1 = 0;
        $this->map->score_2 = 0;
        $this->map->nb_ot = 0;
        $this->map->status = 0;
        $this->map->save();
    }

    public function createFromPreset($team_a, $team_b, $season, $settings)
    {
        $team_a = ($team_a instanceof Team) ? $team_a->id : $team_a;
        $team_b = ($team_b instanceof Team) ? $team_b->id : $team_b;

        $this->ip = $settings['server_ip'];
        $this->server_id = $settings['server_id'];
        $this->season_id = ($season instanceof Season) ? $season->id : $season;
        $this->team_a_name = $team_a;
        $this->team_b_name = $team_b;
        $this->status = $settings['status'];
        $this->max_round = $settings['max_round'];
        $this->rules = $settings['ruleset'];
        $this->overtime_startmoney = $settings['overtime']['start_money'];
        $this->overtime_max_round = $settings['overtime']['max_rounds'];
        $this->config_full_score = $settings['play_all_rounds'];
        $this->config_ot = $settings['overtime']['enabled'];
        $this->config_streamer = $settings['wait_for_streamer'];
        $this->config_knife_round = $settings['knife_round'];
        $this->auto_start = $settings['auto_start'];        
        $this->auto_start_time = $settings['auto_start_time'];
        $this->score_a = 0;
        $this->score_b = 0; 

        if ($settings['password']['random']) {
            $this->config_password = str_random(15);
        } else {
            $this->config_password = $settings['password']['value'];
        }

        $this->map_selection_mode = $settings['map_selection_mode'];
        $this->save();

        $map = new Map;
        $map->match_id = $this->id;
        $map->map_name = $settings['map']['map_name'];
        $map->score_1 = 0;
        $map->score_2 = 0;
        $map->current_side = 'ct';
        $map->status = 0;
        $map->maps_for = 'default';
        $map->nb_ot = 0;
        $map->save();

        $this->current_map = $map->id;
        $this->setAuthKey();
        $this->save();

        return $this;
    }

    public function setAuthKey()
    {
        if (!empty($this->config_authkey)) return false;
        $this->config_authkey = uniqid(mt_rand(), true);
        return true;
    }

    public function setRandomServer($exclude_servers = null)
    {
        $servers = Server::orderByRaw("RAND()")->get();
        $matches = Match::whereBetween('status', [1, 13])->lists('server_id');
        $exclude_servers = collect($exclude_servers);

        foreach ($servers as $server) {
            if (!$matches->contains($server->id)) {
                if (!is_null($exclude_servers)) {
                    if ($exclude_servers->contains($server->id)) continue;
                }

                $this->server_id = $server->id;
                $this->ip = $server->ip;
                $this->save();

                return $server;
            }
        }

        return false;
    }

    public function stopMatch($restart = true)
    {
        $s = Socket::send('stop', $this);

        if ($restart) {
            $this->status = 0;
            $this->enable = 0;
            $this->save();
        }
    }

    public function executeRcon($command)
    {
        return Socket::send('executeCommand', $this, $command);
    }

    public function skipKnife()
    {
        return Socket::send('passknife', $this);
    }

    public function forceKnife()
    {
        return Socket::send('forceknife', $this);
    }

    public function endKnife()
    {
        return Socket::send('forceknifeend', $this);
    }

    public function forceStart()
    {
        return Socket::send('forcestart', $this);
    }

    public function togglePause()
    {
        return Socket::send('pauseunpause', $this);
    }

    public function fixTeamNames()
    {
        return Socket::send('fixsides', $this);
    }

    public function toggleStreamerReady()
    {
        return Socket::send('streamready', $this);
    }
}
