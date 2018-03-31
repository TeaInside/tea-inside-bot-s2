<?php

namespace Bot\Telegram\Response\Command;

use DB;
use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Models\Group as GroupModel;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Tags extends CommandAbstraction implements EventContract
{
   /* public function addTag()
    {
        if (GroupModel::isAdmin($this->e['user_id'], $this->e['chat_id'])) {
            $data = [
                        ":group_id" => $this->e['chat_id'],
                        ":creator"  => $this->e['user_id'],
                        ":created_at"=> date("Y-m-d H:i:s")
                    ];
            switch ($this->e['msg_type']) {
                case 'text':
                    $data[':type'] = 'text';
                    $st = DB::prepare("INSERT INTO `group_tags` (`group_id`, `creator`, `type`, `callback_count`, `created_at`) VALUES (:group_id,:creator,:type,0,:created_at);");
                    pc($st->execute($data), $st);
                    $st = DB::prepare("INSERT INTO `group_tags_data` (`tag_identifier`, `trigger`, `text`, `file_id`) ")
                    break;
                
                default:
                    
                    break;
            }
        }
    }*/
}
