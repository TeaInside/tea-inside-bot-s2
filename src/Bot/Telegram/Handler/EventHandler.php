<?php

namespace Bot\Telegram\Handler;

use Bot\Telegram\Handler\EventHandler\User;
use Bot\Telegram\Handler\EventHandler\Group;
use Bot\Telegram\Events\EventRecognition as Event;

class EventHandler
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
}
