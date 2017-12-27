<?php

namespace Bot\Telegram\Handler\Events;

use Telegram as B;
use Bot\Telegram\Models\User;
use Bot\Telegram\Models\Group;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Handler\Events\UserHandler;
use Bot\Telegram\Events\EventRecognition as Event;

class GroupHandler implements EventContract
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
        $this->recognizer();
        $this->handle();
        $no_action = 0;
        $class = '\Bot\Telegram\Handler\Events\GroupMessage';
        switch ($this->e['msg_type']) {
             case 'text':
                $fr .= "Text";
                break;
            case 'photo':
                $fr .= "Photo";
                break;
            case 'sticker':
                $fr .= "Sticker";
                break;
            default:
                return false;
            break;
        }

        if (! $no_action) {
            $q = new $class($this->e);
            $q->run();
        }
    }

    private function recognizer()
    {
        $handler = new UserHandler($this->e);
        $handler->handle(1);
    }

    private function handle()
    {
        if (Group::getInfo($this->e['chat_id'])) {
            Group::msgCount($this->e['chat_id']);
        } else {
            $raws = json_decode(B::getChatAdministrators(["chat_id" => $this->e['chat_id']])['content'], true);
            if (isset($raws['result'])) {
                $admins = [];
                $creator = null;
                foreach ($raws['result'] as $key => $val) {
                    $val['user']['user_id'] = $val['user']['id'];
                    $val['user']['display_name'] = $val['user']['first_name'].(isset($val['user']['last_name'])?" ".$val['user']['last_name']:"");
                    $admins[] = $val;
                    if ($val['status'] === "creator") {
                        $creator = $val['user']['user_id'];
                    }
                }
                Group::insert(
                    [
                        "group_id"  => $this->e['chat_id'],
                        "username"  => $this->e['chatuname'],
                        "name"      => $this->e['chattitle'],
                        "private_link"  => null,
                        "photo"     => null,
                        "creator"   => $creator
                    ]
                );
                Group::insertAdmins($admins, $this->e['chat_id']);
            }
        }
    }
}
