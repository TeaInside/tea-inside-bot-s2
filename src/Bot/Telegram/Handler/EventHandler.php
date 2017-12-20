<?php

namespace Bot\Telegram\Handler;

use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Handler\EventHandler\User;
use Bot\Telegram\Handler\EventHandler\Group;
use Bot\Telegram\Handler\Events\GroupHandler;
use Bot\Telegram\Events\EventRecognition as Event;

class EventHandler implements EventContract
{
	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	protected $e;

	/**
	 * Constructor.
	 *
	 * @param \Bot\Telegram\Events\EventRecognition $event
	 */
	final public function __construct(Event $event, $chattype = "private")
	{
		$this->e = $event;
		$this->chattype = $chattype;
	}

	public function run()
	{
		if ($this->e['chattype'] === "private") {
			$this->privateMessage();
		} else {
			$this->groupMessage();
		}
		return true;
	}

	private function groupMessage()
	{
		$a = new GroupHandler($this->e);
		$a->run();
	}
}
