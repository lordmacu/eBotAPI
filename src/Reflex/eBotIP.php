<?php

namespace Reflex;

use Reflex\Singleton;

class eBotIP extends Singleton
{
	protected $ebot_ip;
	protected $ebot_port;

	public function geteBotIP()
	{
		if (empty($this->ebot_ip)) {
			throw new IPNotSetException('You need to set the eBot IP before running anything.');
		}

		return $this->ebot_ip;
	}

	public function geteBotPort()
	{
		if (empty($this->ebot_port)) {
			return 12360;
		}

		return $this->ebot_port;
	}

	public function seteBotIP($ebot_ip)
	{
		$this->ebot_ip = $ebot_ip;
	}

	public function seteBotPort($ebot_port)
	{
		$this->ebot_port = $ebot_port;
	}

}