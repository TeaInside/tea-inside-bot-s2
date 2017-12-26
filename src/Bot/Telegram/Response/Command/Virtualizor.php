<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Plugins\Virtualizor\Interpreter\PHP;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Virtualizor extends CommandAbstraction implements EventContract
{
	public function php()
	{
		$st = new PHP($this->e['text']);
		$st = trim($st->execute());
		if ($st === "") {
			$st = "~";
		} else {
			$st = htmlspecialchars(str_replace(["<br />", "<b>", "</b>"], ["\n", "{@~b~@}", "{@~/b~@}"], $st), ENT_QUOTES, 'UTF-8');
			$st = str_replace(["{@~b~@}", "{@~/b~@}"], ["<b>", "</b>"], $st);
			$st = $st === "" ? "~" : $st;
		}
		B::bg()::sendMessage(
			[
				"chat_id" => $this->e['chat_id'],
				"text"	  => $st,
				"parse_mode" => "HTML",
				"reply_to_message_id" => $this->e['msg_id']
			]
		);
	}
}
