<?php

namespace Bot\Telegram\Handler\Events;

use Bot\Telegram\Models\User;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;

class UserHandler implements EventContract
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

    public function run()
    {
        $this->handle();
        $class = '\Bot\Telegram\Handler\Events\PrivateMessage\\';
        switch ($this->e['msg_type']) {
            case 'text':
                $class .= "Text";
                break;
            case 'photo':
                $class .= "Photo";
                break;
            case 'sticker':
                $class .= "Sticker";
                break;
            default:
                return false;
                break;
        }

        $q = new $class($this->e);
        $q->run();
    }

    public function handle($isGroup = 0)
    {
        if ($isGroup) {
            if ($user = User::getInfo($this->e['user_id'])) {
                $shouldUpdate = 0;
                $historyTrack = 0;
                $user['has_private_message'] === 1 or $shouldUpdate = 1;
                $user['first_name'] === $this->e['first_name'] or $historyTrack = $shouldUpdate = 1;
                $user['last_name'] === $this->e['last_name'] or $historyTrack = $shouldUpdate = 1;
                $user['username']  === $this->e['username'] or $historyTrack = $shouldUpdate = 1;
                if ($shouldUpdate) {
                    User::update(
                        [
                            "user_id"  => $this->e['user_id'],
                            "username" => $this->e['username'],
                            "first_name" => $this->e['first_name'],
                            "last_name" => $this->e['last_name'],
                            "has_private_message" => 1,
                            "authority" => $user['authority'],
                            "display_name" => $this->e['name']
                        ],
                        $historyTrack
                    );
                }
            } else {
                User::insert(
                    [
                        "user_id"   => $this->e['user_id'],
                        "username"  => $this->e['username'],
                        "first_name"=> $this->e['first_name'],
                        "last_name" => $this->e['last_name'],
                        "display_name"=> $this->e['name'],
                        "photo" => null,
                        "authority" => 'user',
                        "is_bot"    => (int) $this->e['is_bot'],
                        "created_at"=> date('Y-m-d H:i:s')
                    ]
                );
            }
        } else {
            if ($user = User::getInfo($this->e['user_id'])) {
                $shouldUpdate = 0;
                $historyTrack = 0;
                $user['has_private_message'] === 1 or $shouldUpdate = 1;
                $user['first_name'] === $this->e['first_name'] or $historyTrack = $shouldUpdate = 1;
                $user['last_name'] === $this->e['last_name'] or $historyTrack = $shouldUpdate = 1;
                $user['username']  === $this->e['username'] or $historyTrack = $shouldUpdate = 1;
                if ($shouldUpdate) {
                    User::update(
                        [
                            "user_id"  => $this->e['user_id'],
                            "username" => $this->e['username'],
                            "first_name" => $this->e['first_name'],
                            "last_name" => $this->e['last_name'],
                            "has_private_message" => 1,
                            "authority" => $user['authority'],
                            "display_name" => $this->e['name']
                        ],
                        $historyTrack
                    );
                }
            } else {
                User::insert(
                    [
                        "user_id"   => $this->e['user_id'],
                        "username"  => $this->e['username'],
                        "first_name"=> $this->e['first_name'],
                        "last_name" => $this->e['last_name'],
                        "display_name"=> $this->e['name'],
                        "photo" => null,
                        "authority" => 'user',
                        "is_bot"    => (int) $this->e['is_bot'],
                        "has_private_message" => 1,
                        "created_at"=> date('Y-m-d H:i:s')
                    ]
                );
            }
        }
    }
}
