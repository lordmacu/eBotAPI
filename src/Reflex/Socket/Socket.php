<?php

namespace Reflex\Socket;

use Reflex\Helpers\Encryption;

class Socket
{
	public static function send($command, $match, $ebotip, $ebotport = 12360, $extra)
	{
		$data = "{$match->id} {$command} {$match->server->ip}";
		if(!empty($extra)) $data = "{$data} {$extra}";
		$data = Encryption::encrypt($data, $match->config_authkey, 256);
		$data = json_encode([$data, $match->server->ip]);

		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		return socket_sendto($socket, $data, strlen($data), 0, $ebotip, $ebotport);
	}
}