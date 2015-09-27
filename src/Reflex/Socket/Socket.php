<?php

namespace Reflex\Socket;

use Reflex\Helpers\Encryption;

class Socket
{
	public static function send($command, $match, $extra = '')
	{
		$config = config('ebot-reflex');
		$data = "{$match->id} {$command} {$match->server->ip}";
		if(!empty($extra)) $data = "{$data} {$extra}";
		$data = Encryption::encrypt($data, $match->config_authkey, 256);
		$data = json_encode([$data, $match->server->ip]);

		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		return socket_sendto($socket, $data, strlen($data), 0, $config['ebot_ip'], $config['ebot_port']);
	}
}
