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
        $fail = 0;
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
                $msg = $st->get();    
            }
            B::bg()::sendMessage(
                [
                    "text" => $msg,
                    "chat_id" => $this->e['chat_id'],
                    "reply_to_message_id" => $this->e['msg_id']
                ]
            );
        } else {
            $msg = "Penulisan format translate salah!

Berikut ini adalah penulisan yang benar :
<code>/tl [from] [to] [string]</code>

Contoh :
<code>/tl id en Apa kabar?</code>";
            $fail = 1;
        }

        if ($fail) {
            B::bg()::sendMessage(
                    [
                        "text" => $msg,
                        "chat_id" => $this->e['chat_id'],
                        "reply_to_message_id" => $this->e['msg_id'],
                        "parse_mode" => "HTML"
                    ]
                );
        }
        return true;
    }


    public function translateToRepliedMessage()
    {
        $fail = 0;
        if (! empty($this->e['reply_to']['text'])) {
            $str = explode(" ", $this->e['text']. 4);
            if (count($str) >= 3) {
                $str[1] = strtolower($str[1]);
                $str[2] = strtolower($str[2]);
                if (! isset(GT::LANG_LIST[$str[1]])) {
                    $msg = "Language ".$str[1]." not found!";
                } elseif (! isset(GT::LANG_LIST[$str[1]])) {
                    $msg = "Language ".$str[2]." not found!";
                } else {
                    $st = new GoogleTranslatePlugin($this->e['reply_to']['text'], $str[1], $str[2]);
                    $msg = $st->get();    
                }
                B::bg()::sendMessage(
                    [
                        "text" => $msg,
                        "chat_id" => $this->e['chat_id'],
                        "reply_to_message_id" => $this->e['reply_to']['message_id']
                    ]
                );
            } else {
            }

            if ($fail) {
                B::bg()::sendMessage(
                        [
                            "text" => $msg,
                            "chat_id" => $this->e['chat_id'],
                            "reply_to_message_id" => $this->e['msg_id'],
                            "parse_mode" => "HTML"
                        ]
                    );
            }
        }


        return true;
    }
}
