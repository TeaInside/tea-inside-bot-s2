<?php

namespace Bot\Telegram;

use Bot\Telegram\Events\SaveEvent\User;
use Bot\Telegram\Events\EventRecognition as Event;

/**
 *
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class SaveEvent
{
   

    /**
     * @var \Bot\Telegram\Events\EventRecognition
     */
    private $e;


    /**
     * Constructor.
     *
     * @param \Bot\Telegram\Events\EventRecognition $event
     */
    public function __construct(Event $event)
    {
        $this->e = $event;
    }

    /**
     * @return bool
     */
    public function action()
    {
        if ($this->e['chattype'] === "private") {
            $this->privateAction();
            $fr = "\\Bot\\Telegram\\Events\\SaveEvent\\PrivateMessage\\";
        } else {
            $this->groupAction();
            $fr = "\\Bot\\Telegram\\Events\\SaveEvent\\GroupMessage\\";
        }


        switch ($this->e['msg_type']) {
            case 'text':
                $fr .= "Text";
                break;
            
            default:
                break;
        }

        $st = new $fr($this->e);
        $st->execute();
    }

    private function privateAction()
    {

    }

    private function groupAction()
    {
        $a = new User($this->e);
        $a->execute();
        $a = new Group($this->e);
        $a->execute();
    }
}
