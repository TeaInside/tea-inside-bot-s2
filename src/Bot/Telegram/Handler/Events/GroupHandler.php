<?php

namespace Bot\Telegram\Handler\Events;

use Bot\Telegram\Models\User;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Handler\Events\UserHandler;
use Bot\Telegram\Events\EventRecognition as Event;

class GroupHandler implements EventContract
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


    public function run()
    {
    	$this->recognizer();
    	$class = '\Bot\Telegram\Handler\Events\GroupMessage';
    	switch ($this->e['msg_type']) {
    		case 'text':
    				$class .= '\Text';
    			break;
    		
    		default:
    			break;
    	}

    	$q = new $class($this->e);
    	$q->run();
    }

    private function recognizer()
    {
    	$handler = new UserHandler($this->e);
    	$handler->handle();
    }
}