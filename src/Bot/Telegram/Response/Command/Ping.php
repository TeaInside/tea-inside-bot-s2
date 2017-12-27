<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Ping extends CommandAbstraction implements EventContract
{

    /**
     * "/start" command.
     *
     */
    public function ping()
    {
        $st = json_decode(B::sendMessage(
            [
                "text" => "Pong!",
                "chat_id" => $this->e['chat_id']
                "reply_to_message_id" => $this->e['msg_id']
            ]
        )['content'], true);
        if (isset($st['result']['message_id'])) {
            B::bg()::editMessageText(
                [
                    "chat_id" => $this->e['chat_id'],
                    "message_id" => $st['result']['message_id'],
                    "text" => "Pong!\n".((time() - $this->e['date']) + round(microtime(true) - $start, 4))." s"
                ]
            );
        }
        return false;
    }
}
