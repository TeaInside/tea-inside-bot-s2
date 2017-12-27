<?php

namespace Bot\Telegram\Handler\Events\PrivateMessage;

use DB;
use Bot\Telegram\Handler\Events\SaveEvent;

class Photo extends SaveEvent
{
    public function run()
    {
        $st = DB::prepare("INSERT INTO `private_messages` (`message_id`, `user_id`, `type`, `reply_to_message_id`, `created_at`) VALUES (:message_id, :user_id, :type, :reply_to_message_id, :created_at);");
        pc($st->execute(
            [
                ":message_id" => $this->e['msg_id'],
                ":user_id"    => $this->e['user_id'],
                ":type"       => 'photo',
                ":reply_to_message_id" => isset($this->e['reply_to']) ? $this->e['reply_to']['message_id'] : null,
                ":created_at" => date("Y-m-d H:i:s")
            ]
        ), $st);
        $last = DB::lastInsertId();
        $st = DB::prepare("INSERT INTO `private_messages_data` (`message_identifier`, `text`, `file_id`) VALUES (:message_identifier, :text_, :file_id);");
        $bestPhoto = end($this->e['photo']);
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
