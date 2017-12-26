<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Plugins\Virtualizor\Compiler\C;
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
		$sq = new PHP($this->e['text']);
		$st = trim($sq->execute());
		$file = $sq->file;
		unset($sq);
		if ($st === "") {
			$st = "~";
		} else {
			$rn = substr(sha1(time()), 0, 3).".php";
			$st = htmlspecialchars(str_replace([$file, "<br />", "<b>", "</b>"], ["/tmp/{$rn}", "\n", "{@~b~@}", "{@~/b~@}"], $st), ENT_QUOTES, 'UTF-8');
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

	public function c()
	{
		$sq = new C(substr($this->e['text'], 3));
		$st = $sq->execute();
		$file = $sq->file;
		unset($sq);
		if ($st === "") {
			$st = "~";
		} else {
			$rn = substr(sha1(time()), 0, 3).".c";
			$st = htmlspecialchars(str_replace([$file], ["/tmp/{$rn}"], $st), ENT_QUOTES, 'UTF-8');
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
