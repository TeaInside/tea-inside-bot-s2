<?php

namespace Bot\Telegram\Response\Command;

use DB;
use Curl\Curl;
use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Models\Group as GroupModel;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;
use Bot\Telegram\Plugins\WhatAnime\WhatAnime as WhatAnimePlugin;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class WhatAnime extends CommandAbstraction implements EventContract
{
	public function whatanime()
	{
		if ($this->e['msg_type'] === "photo") {
			$photo = $this->e['photo'][count($this->e['photo']) - 1];
		} else {
			if (! empty($this->e['reply_to'])) {
				$photo = isset($this->e['reply_to']['photo']) ? $this->e['reply_to']['photo'][count($this->e['reply_to']['photo']) - 1] : null;
				var_dump($this->e['reply_to']);
			}
		}
		if (isset($photo)) {
			$f = json_decode(B::sendMessage(
				[
					"chat_id" => $this->e['chat_id'],
					"text"	  => "Downloading your image...",
					"reply_to_message_id" => $this->e['msg_id'],
				]
			)['content'], true);
			$st = json_decode(B::getFile(
				[
					"file_id" => $photo['file_id']
				]
			)['content'], true);
			if (isset($st['result']['file_id'])) {
				$st = new Curl("https://api.telegram.org/file/bot/".TOKEN."/".$st['result']['file_id']);
				var_dump(3);
				print B::editTextMessage(
					[
						"chat_id" => $this->e['chat_id'],
						"message_id" => $f['result']['message_id'],
						"text"	=> "Searching..."
					]
				)['content']."\n";
				$st = new WhatAnimePlugin($q = $st->exec());
				file_put_contents(STORAGE."/test.jpg", $q);
				$st = $st->get();
				var_dump(4);
				if ($st['data'] === false) {
					
				} else {
					B::bg()::sendChatAction(
		                [
		                    "chat_id" => $this->e['chat_id'],
		                    "action"  => "typing"
		                ]
		            );
		            B::editTextMessage(
						[
							"chat_id" => $this->e['chat_id'],
							"message_id" => $f['result']['message_id'],
							"text"	=> json_encode($st)
						]
					);
				}
			}
		} else {
			B::sendMessage(
				[
					"chat_id" => $this->e['chat_id'],
					"text"	  => "Balas pesan ini dengan screenshot anime!",
					"reply_to_message_id" => $this->e['msg_id'],
					"reply_markup" => json_encode(["force_reply"=>true,"selective"=>true])
				]
			);
		}
	}
}
