<?php

namespace Bot\LINE;

use Bot\LINE\Bot;
use Bot\LINE\Response\Command;

class Response
{
	/**
	 * @var \Bot\LINE\Bot
	 */
	private $b;

	/**
	 * Constructor.
	 *
	 * @param \Bot\LINE\Bot $bot
	 */
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}

	public function run()
	{
		foreach ($this->b->e as $val) {
			if ($val['msgType'] === "text") {
				$cmd = new Command($val);
				$cmd->run();
			}
		}
	}
}