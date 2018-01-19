<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Plugins\Youtube\YoutubeDownloader;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Youtube extends CommandAbstraction implements EventContract
{
	public function listFormat()
	{
		$st = explode(" ", $this->e['text'], 2);
		if (isset($st[1])) {
			return $this->getListFormat(new YoutubeDownloader($st[1]));
		}
	}

	private function getListFormat(YoutubeDownloader $st)
	{
		if (is_array($st = $st->listFormat())) {
			foreach ($st as $key => $val) {
				$keyboards[] = [[
					"callback_data" => $key,
					"text" => $val['extension']." ".$val['resolution']." ".$val['description']
				]];
			}
			B::bg()::sendMessage(
				[
					"chat_id" =>  $this->e['chat_id'],
					"reply_to_message_id" => $this->e['msg_id'],
					"text" => "Select your preferred format!",
					"reply_markup" => json_encode(
						[
							"inline_keyboard" => $keyboards
						]
					)
				]
			)['content'];
		} else {
			B::bg()::sendMessage(
				[
					"chat_id" => $this->e['chat_id'],
					"reply_to_message_id" => $this->e['msg_id'],
					"text" => "Not Found!"
				]
			);
		}
		return true;
	}
}
