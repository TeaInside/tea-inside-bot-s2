<?php

namespace Bot\Telegram;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Events\User;
use Bot\Telegram\Response\Command;
use Bot\Telegram\Response\NewChatMembers;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Contracts\Response as ResponseContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Response implements EventContract, ResponseContract
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
        Lang::build(new User($this->e), $this->e);
    }

    /**
     * Action.
     *
     * @return string
     */
    public function action()
    {
        if (isset($this->e['text'])) {
            $resp = new Command($this->e);
            if (! $resp->action()) {
            }
        }
        if ($this->e['msg_type'] === "new_chat_members") {
            $resp = new NewChatMembers($this->e);
            $resp->action();
        }
        if (isset($resp)) {
            if (! in_array(ResponseContract::class, class_implements($resp))) {
                throw new \Exception(
                    "Instance must be an object that implements ".ResponseContract::class,
                    1
                );
            }
            return get_class($resp);
        }
        return null;
    }
}
