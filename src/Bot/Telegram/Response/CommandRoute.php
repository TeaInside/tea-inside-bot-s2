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
        $this->set(
            function () {
                return true;
            },
            function () {
                B::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text"  => "Ok"
                    ]
                );
                return true;
            }
        );
    }
}
