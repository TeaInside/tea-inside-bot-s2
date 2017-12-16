<?php

namespace Bot\Telegram\Events\GroupMessage;

use DB;
use Bot\Telegram\Abstraction\SaveEvent;
use Bot\Telegram\Models\Group as GroupModel;

class Text extends SaveEvent
{
	public function save()
	{
		return GroupModel::saveTextMessage(
			$this->e['chat_id'],
			$this->e['user_id'],
			$this->e['msg_id'],
			$this->e['text'],
			(
				isset($this->e['reply_to_message_id']['message_id']) ? $this->e['reply_to_message_id']['message_id'] : null
			)
		);
	}
}