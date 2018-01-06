<?php

namespace Bot\LINE\Response\Command;

use LINE;
use Telegram;
use Bot\LINE\Contracts\CommandContract;
use Bot\LINE\Abstraction\CommandFoundation;

class Solid extends CommandFoundation implements CommandContract
{
	public function solidDelivery()
	{
		if ($this->b['msgType'] === "text") {
			$u = json_decode(
	            LINE::profile(
	                $this->b['userId'], (
	                ($this->b->['userId'] !== "private" ? $this->b['chatId'] : null)
	                )
	            )['content'], true
	        );
	        isset($u['displayName']) or $u['displayName'] = $this->b['chatId'];
	        $msg = "<b>".htmlspecialchars($u['displayName'])."</b>\n".htmlspecialchars($this->b['text']);
			Telegram::bg()::sendMessage(
	         	[
					"text" => $msg,
					"chat_id" => -1001313979330,
					"parse_mode" => "HTML"
	         	]
	         );
			Telegram::bg()::sendMessage(
	         	[
	         		"text" => $msg,
					"chat_id" => -1001134449138,
					"parse_mode" => "HTML"
	         	]
	        );
		} elseif ($this->b['msgType'] === "image") {
			is_dir(data."/line") or mkdir(data."/line");
            is_dir(data."/line/tmp") or mkdir(data."/line/tmp");
            file_put_contents(data."/line/tmp/".($t = time()."_".$this->b['msgId']).".jpg", LINE::getContent($this->b->msgid)['content']);
            $u = json_decode(
                LINE::profile(
                    $this->b->userid, (
                    ($this->b->chattype !== "private" ? $this->b->chat_id : null)
                    )
                )['content'], true
            );
            isset($u['displayName']) or $u['displayName'] = $this->b->userid;
            $msg = htmlspecialchars($u['displayName']);
		}
	}
}

