<?php

namespace Bot\Telegram\Abstraction;

use Bot\Telegram\Events\EventRecognition as Event;

abstract class SaveEvent
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
	final public function __construct(Event $event)
	{
		$this->e = $event;
	}

	abstract public function save();
}