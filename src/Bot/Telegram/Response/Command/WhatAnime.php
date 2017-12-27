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
				var_dump("https://api.telegram.org/file/bot".TOKEN."/".$st['result']['file_path']);
				$st = new Curl("https://api.telegram.org/file/bot".TOKEN."/".$st['result']['file_path']);
				var_dump(3);
				print B::editMessageText(
					[
						"chat_id" => $this->e['chat_id'],
						"message_id" => $f['result']['message_id'],
						"text"	=> "Searching..."
					]
				)['content']."\n";
				B::bg()::sendChatAction(
	                [
	                    "chat_id" => $this->e['chat_id'],
	                    "action"  => "typing"
	                ]
	            );
				$st = new WhatAnimePlugin($q = $st->exec());
				file_put_contents(STORAGE."/test.jpg", $q);
				$st = $st->get();
				var_dump(4);
				if ($st['data'] === false) {
					B::editMessageText(
						[
							"chat_id" => $this->e['chat_id'],
							"message_id" => $f['result']['message_id'],
							"text"	=> "Not found!"
						]
					);
				} else {
					$e = ['session','anime','title','title_english','title_romaji','episode','file','diff','token','tokenthumb','i','t'];
					$text = "Hasil pencarian\n\n";
					foreach ($st['data'] as $k => $v) {
					 	in_array($k, $e) and $text .= "<b>".htmlspecialchars(ucwords(str_replace("_", " ", $k))).":</b> ".htmlspecialchars($v)."\n";
					}

		            B::editMessageText(
						[
							"chat_id" => $this->e['chat_id'],
							"message_id" => $f['result']['message_id'],
							"text"	=> $text,
							"parse_mode" => "HTML"
						]
					);
					B::bg()::sendChatAction(
						[
							"chat_id" => $this->e['chat_id'],
							"action"  => "upload_video"
						]
					);

					$ff = function ($seconds)
					{
						if ($seconds == 0) return "now";
							$duration = [
								"tahun" => floor($seconds / (60 * 60 * 24 * 365)),
								"hari" => $seconds / (60 * 60 * 24) % 365,
								"jam" => $seconds / (60 * 60) % 24,
								"menit" => $seconds / 60 % 60,
								"detik" => $seconds % 60,
							];
							$timeUnits = [];
							foreach ($duration as $key => $value) {
								if ($value > 0) {
									$timeUnits[] = $value.' '.$key;
								}
							}
							$output = array_reduce($timeUnits, function($carry, $item) {
								return $carry == '' ? $item : $carry.' '.$item;
							},'');
							return $output;
					};

					B::bg()::sendVideo(
						[
							"chat_id" => $this->e['chat_id'],
							"video" => $st['video_url'],
							"reply_to_message_id" => $this->e['msg_id'],
							"caption" => "Berikut ini adalah cuplikan anime dari hasil pencarian\nDurasi :".$ff($st['data']['start']). " sampai ". $ff($st['data']['end']),
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
