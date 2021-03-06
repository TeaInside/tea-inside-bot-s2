<?php

namespace Bot\Telegram\Handler\Events\GroupMessage;

use DB;
use Bot\Telegram\Handler\Events\SaveEvent;

class Photo extends SaveEvent
{
    public function run()
    {
        $st = DB::prepare("INSERT INTO `group_messages` (`group_id`, `message_id`, `sender`, `type`, `reply_to_message_id`, `created_at`) VALUES (:group_id, :message_id, :sender, :type, :reply_to_message_id, :created_at);");
        pc($st->execute(
            [
                ":group_id"     => $this->e['chat_id'],
                ":message_id"   => $this->e['msg_id'],
                ":sender"       => $this->e['user_id'],
                ":type"             => 'photo',
                ":reply_to_message_id"  => isset($this->e['reply_to']['message_id']) ? $this->e['reply_to']['message_id'] : null,
                ":created_at"   => date("Y-m-d H:i:s")
            ]
        ), $st);
        $last = DB::pdoInstance()->lastInsertId();
        $st = DB::prepare("INSERT INTO `group_messages_data` (`message_identifier`, `text`, `file_id`) VALUES (:message_identifier, :text_, :file_id);");
        $bestPhoto = $this->e['photo'][count($this->e['photo']) - 1];
        pc($st->execute(
            [
                ":message_identifier" => $last,
                ":text_"    => $this->e['text'],
                ":file_id"  => $bestPhoto['file_id']
            ]
        ), $st);
        return true;
    }
}

