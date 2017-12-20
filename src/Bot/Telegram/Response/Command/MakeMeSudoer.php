<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Models\User;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class MakeMeSudoer extends CommandAbstraction implements EventContract
{

    /**
     * "/help" command.
     *
     */
    public function make()
    {
       if (User::addSudoer($this->e['user_id'])) {
            B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['user_id'],
                    "text"    => "You have been promoted to be sudoer!",
                    "parse_mode"=> "HTML"
                ]
            );
        } 
    }
}
