<?php

namespace Bot\Telegram\Handler\Events;


use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;

abstract class SaveEvent implements EventContract
{

	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	private $e;

	/**
     * Constructor.
     *
     * @param \Bot\Telegram\Events\EventRecognition $event
     */
    public function __construct(Event $event)
    {
    	$this->e = $event;
    }

    abstract public function run();
}