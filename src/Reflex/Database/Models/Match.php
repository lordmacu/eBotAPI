<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
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

    protected $appends = ['connect', 'gotv_connect'];

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
        return $this->hasOne('\Reflex\Database\Models\Server', 'id', 'server_id');
    }

    public function season()
    {
        return $this->belongsTo('\Reflex\Database\Models\Season');
    }

    public function teamA()
    {
        return $this->hasOne('\Reflex\Database\Models\Team', 'id', 'team_a');
    }

    public function teamB()
    {
        return $this->hasOne('\Reflex\Database\Models\Team', 'id', 'team_b');
    }

    public function map()
    {
        return $this->hasOne('\Reflex\Database\Models\Map', 'id', 'current_map');
    }

    public function getConnectAttribute()
    {
        return "connect {$this->server->ip};; password {$this->config_password}";
    }

    public function getGotvConnectAttribute()
    {
        return "connect {$this->server->tv_ip}";
    }

    public function stopMatch($restart = true)
    {
        return Socket::send(($restart ? 'stop' : 'stopNoRs'), $this, ''); // TODO Get eBot Server IP
    }

    public function executeRcon($command)
    {
        return Socket::send('executeCommand', $this, '', 12360, $command);
    }

    public function skipKnife()
    {
        return Socket::send('passknife', $this, '');
    }

    public function forceKnife()
    {
        return Socket::send('forceknife', $this, '');
    }

    public function endKnife()
    {
        return Socket::send('forceknifeend', $this, '');
    }

    public function forceStart()
    {
        return Socket::send('forcestart', $this, '');
    }

    public function togglePause()
    {
        return Socket::send('pauseunpause', $this, '');
    }

    public function fixTeamNames()
    {
        return Socket::send('fixsides', $this, '');
    }

    public function toggleStreamerReady()
    {
        return Socket::send('streamready', $this, '');
    }
}
