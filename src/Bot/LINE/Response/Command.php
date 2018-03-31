<?php

namespace  Bot\LINE\Response;

use Closure;
use Bot\LINE\Bot;
use Bot\LINE\Response\CommandRoute;

class Command
{
	use CommandRoute;

	/**
	 * @var \Bot\LINE\Bot
	 */
	private $b;

	/**
	 * @var array
	 */
	private $cmd = [];

	/**
	 * Constructor.
	 *
	 * @param \Bot\LINE\Bot $bot
	 */
	public function __construct($data)
	{
		$this->b = $data;
	}

	public function run()
	{
		$this->invokeRoute();
		foreach ($this->cmd as $key => $val) {
			if ($val[0]()) {
				if (is_string($val[1])) {
					$val[1] = explode("@", $val[1]);
					if (count($val) === 2) {
						$val[1][0] = '\Bot\LINE\Response\Command\\'.$val[1][0];
						$st = new $val[1][0]($this->b);
						if ($st->{$val[1][1]}()) {
							return true;
						}
					} else {
						throw new \Exception("Invalid callback", 1);
					}
				} elseif (is_callable($val[1])) {
					if ($val[1]()) {
						return true;
					}
				}
			}
		}
		return true;
	}

	private function set(Closure $condition, $callback)
	{
		$this->cmd[] = [$condition, $callback];
	}
}