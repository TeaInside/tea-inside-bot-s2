<?php

namespace Bot\Telegram\Contracts;

use Bot\Telegram\Events\EventRecognition as Event;

interface EventContract
{
    /**
     * Constructor.
     *
     * @param \Bot\Telegram\Events\EventRecognition $event
     */
    public function __construct(Event $event);
}
