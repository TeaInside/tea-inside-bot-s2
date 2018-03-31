<?php

namespace Bot\Telegram\Response;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Models\Group;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Contracts\Response as ResponseContract;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class NewChatMembers implements EventContract, ResponseContract
{

    /**
     * @var \Bot\Telegram\Events\EventRecognition
     */
    private $e;

    /**
     * @var array
     */
    private $rotues = [];

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
     * Response action
     */
    public function action()
    {
        if ($group = Group::getSetting($this->e['chat_id'])) {
            if (! empty($group['welcome_message'])) {
                foreach ($this->e['new_chat_members'] as $key => $val) {
                    if ($val['is_bot'] === true and $group['other_bot'] == 0) {
                        B::kickChatMember(
                            [
                                "chat_id" => $this->e['chat_id'],
                                "user_id" => $val['id']
                            ]
                        );
                    } else {
                        $fx = function ($str) use ($val) {
                            return str_replace(
                                [
                                    "{namelink}",
                                    "{first_name}",
                                    "{last_name}",
                                    "{username}",
                                    "{group_name}"
                                ],
                                [
                                    ("<a href=\"tg://user?id={$val['id']}\">".htmlspecialchars($val['first_name'].(isset($val['last_name'])?" ".$val['last_name']:""), ENT_QUOTES, 'UTF-8')."</a>"),
                                    htmlspecialchars($val['first_name'], ENT_QUOTES, 'UTF-8'),
                                    htmlspecialchars((isset($val['last_name']) ? $val['last_name'] : ""), ENT_QUOTES, 'UTF-8'),
                                    htmlspecialchars((isset($val['username']) ? $val['username'] : ""),ENT_QUOTES, 'UTF-8'),
                                    htmlspecialchars($this->e['chattitle'], ENT_QUOTES, 'UTF-8')
                                ], 
                                $str
                            );
                        };
                        B::bg()::sendMessage(
                            [
                                "text" => $fx($group['welcome_message']),
                                "parse_mode" => "HTML",
                                "chat_id" => $this->e['chat_id']
                            ]
                        );
                    }
                }
            }
        }
    }
}
