<?php

namespace Bot\Telegram\Response\Command;

use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Start extends CommandAbstraction implements EventContract
{

	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	private $e;

	/**
	 * Constructor.
	 *
	 * @param Bot\Telegram\Events\EventRecognition $event
	 */
	public function __construct(Event $event)
	{
		$this->e = $event;
	}

	/**
	 * "/start" command.
	 *
	 */
	public function start()
	{
	}
}