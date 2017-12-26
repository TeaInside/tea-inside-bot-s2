<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Contracts\EventContract;
use GoogleTranslate\GoogleTranslate as GT;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;
use Bot\Telegram\Plugins\GoogleTranslate\GoogleTranslate as GoogleTranslatePlugin;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class GoogleTranslate extends CommandAbstraction implements EventContract
{

    public function translate()
    {
        $str = explode(" ", $this->e['text'], 4);
        if (count($str) === 4) {
            $str[1] = strtolower($str[1]);
            $str[2] = strtolower($str[2]);
            if (! isset(GT::LANG_LIST[$str[1]])) {
                $msg = "Language ".$str[1]." not found!";
            } elseif (! isset(GT::LANG_LIST[$str[1]])) {
                $msg = "Language ".$str[2]." not found!";
            } else {
                $st = new GoogleTranslatePlugin($str[3], $str[1], $str[2]);
                B::bg()::sendMessage(
                    [
                        "text" => $st->get(),
                        "chat_id" => $this->e['chat_id'],
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                );
            }
        } else {

        }
        return true;
    }
}
