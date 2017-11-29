<?php

namespace Bot\Telegram;

use Telegram as B;
use Bot\Telegram\Response\Command;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Contracts\Response as ResponseContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Response implements EventContract, ResponseContract
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

	/**
	 * Action.
	 *
	 * @return string
	 */
	public function action()
	{
		$recognizedMessageType = [
			"text" => "Text"
		];
		if (isset($recognizedMessageType[$this->e['msg_type']])) {
			if ($this->e['chattype'] === "private") {
				$event = "\\Bot\\Telegram\\Events\\PrivateMessage\\" . $recognizedMessageType[$this->e['msg_type']];
			} else {
				$event = "\\Bot\\Telegram\\Events\\GroupMessage\\" . $recognizedMessageType[$this->e['msg_type']];
			}
		}
		$resp = new Command($this->e);
		if (! $resp->action()) {
			
		}

		if (! in_array(ResponseContract::class, class_implements($resp))) {
			throw new \Exception(
				"Instance must be an object that implements ".ResponseContract::class, 
				1
			);
		}
		return get_class($resp);
	}
}
