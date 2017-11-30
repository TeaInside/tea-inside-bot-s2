<?php

namespace Bot\Telegram\Response;

use Telegram as B;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
trait CommandRoute
{
    private function buildRoute()
    {

        if (isset($this->e['text'])) {
            $s = explode(" ", $this->e['text'], 2);
        } else {
            $s[0] = "";
        }

        $this->set(
            function () use ($st) {
                return 
                    $st[0] === "/start"||
                    $st[0] === "!start"||
                    $st[0] === "~start";
            },
            "Start@start"
        );
    }
}
