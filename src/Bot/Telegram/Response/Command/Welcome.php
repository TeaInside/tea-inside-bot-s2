<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Models\Group;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Welcome extends CommandAbstraction implements EventContract
{
    public function setWelcome()
    {
        if ($this->e['chattype'] !== "private") {
            $str = explode(" ", $this->e['text'], 2);
            if (! empty($str[1])) {
                if ($info = Group::isAdmin($this->e['user_id'], $this->e['chat_id'])) {
                    if (Group::setWelcome($str[1], $this->e['chat_id'])) {
                        $msg = Lang::get("success_set_welcome_message");
                    } else {
                        $msg = Lang::get("failed_set_welcome_message");
                    }
                    B::bg()::sendMessage(
                        [
                            "chat_id" => $this->e['chat_id'],
                            "text"    => $msg,
                            "parse_mode" => "HTML"
                        ]
                    );   
                }
            }
        } else {
            B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => Lang::get("no_welcome_at_private"),
                    "parse_mode"=> "HTML"
                ]
            );
        }
    }
}
