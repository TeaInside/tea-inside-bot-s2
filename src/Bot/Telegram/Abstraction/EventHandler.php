<?php

namespace Bot\Telegram\Abstraction;

use Bot\Telegram\Events\EventRecognition as Event;

abstract class EventHandler
{
    /**
     * @var \Bot\Telegram\Events\EventRecognition
     */
    protected $e;

    /**
     * @var string
     */
    protected $chattype;

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

    abstract public function run();
}
