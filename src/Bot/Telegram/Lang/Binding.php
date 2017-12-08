<?php

namespace Bot\Telegram\Lang;

use Bot\Telegram\Events\User;
use Bot\Telegram\Events\EventRecognition as Event;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Binding
{
    /**
     * @var \Bot\Telegram\Events\User
     */
    private $user;

    /**
     * @var \Bot\Telegram\Events\EventRecognition
     */
    private $e;

    /**
     * Constructor.
     *
     * @param \Bot\Telegram\Events\User $user
     * @param \Bot\Telegram\Events\EventRecognition
     */
    public function __construct(User $user, Event $event)
    {
        $this->e = $event;
        $this->user = $user;
        $this->buildReplacer();
    }

    /**
     * Bind text.
     *
     * @param string $text
     */
    public function bind($text)
    {
        return str_replace($this->replacer[0], $this->replacer[1], $text);
    }

    /**
     * Build replacer
     */
    private function buildReplacer()
    {
        $this->replacer = [
            [
                "{first_name}",
                "{last_name}",
                "{name}",
                "{namelink}",
                "{first_namelink}",
                "{group_name}",
                "{chat_title}",
                "{chat_link}"
            ],
            [
                e($this->e['first_name']),
                e($this->e['last_name']),
                e($this->e['name']),
                "<a href=\"tg://user?id=".$this->e['user_id']."\">".e($this->e['name'])."</a>",
                "<a href=\"tg://user?id=".$this->e['user_id']."\">".e($this->e['first_name'])."</a>",
                e($this->e['chattitle']),
                e($this->e['chattitle']),
                (
                    $this->e['chatuname'] ? (
                        "<a href=\"https://t.me/" . $this->e['chatuname'] . "\">" . e($this->e['chattitle']) . "</a>"
                    ) : "<code>" . e($this->e['chattitle']) . "</code>"
                )
            ]
        ];
    }
}

function e($str)
{
    $str = is_string($str) ? htmlspecialchars($str, ENT_QUOTES, 'UTF-8') : "";
    return $str;
}
