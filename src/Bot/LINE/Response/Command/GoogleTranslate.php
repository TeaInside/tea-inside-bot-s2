<?php

namespace Bot\LINE\Response\Command;

use LINE;
use Bot\LINE\Contracts\CommandContract;
use GoogleTranslate\GoogleTranslate as GT;
use Bot\LINE\Abstraction\CommandFoundation;
use Bot\Telegram\Plugins\GoogleTranslate\GoogleTranslate as GoogleTranslatePlugin;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class GoogleTranslate extends CommandFoundation implements CommandContract
{

    public function translate()
    {
        $fail = 0;
        $str = explode(" ", $this->b['text'], 4);
        if (count($str) === 4) {
            $str[1] = strtolower($str[1]);
            $str[2] = strtolower($str[2]);
            if (! isset(GT::LANG_LIST[$str[1]]) && $str[1] !== "auto") {
                $msg = "Language ".$str[1]." not found!";
            } elseif (! isset(GT::LANG_LIST[$str[1]]) && $str[1] !== "auto") {
                $msg = "Language ".$str[2]." not found!";
            } else {
                $st = new GoogleTranslatePlugin($str[3], $str[1], $str[2]);
                $msg = $st->get();    
            }
            LINE::bg()::push(
                [
                    "to" => $this->b['chatId'],
                    "messages" => LINE::buildLongTextMessage($msg)
                ]
            );
        } else {
                $msg = "Penulisan format translate salah!

Berikut ini adalah penulisan yang benar :
/tl [from] [to] [string]

Contoh :
/tl id en Apa kabar?";
                $fail = 1;
        }

        if ($fail) {
            LINE::bg()::push(
                [
                    "to" => $this->b['chatId'],
                    "messages" => LINE::buildLongTextMessage($msg)
                ]
            );
        }
        return true;
    }
}
