<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Models\User as UserModel;
use Bot\Telegram\Models\Group as GroupModel;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class AdminHammer extends CommandAbstraction implements EventContract
{

    /**
     * Ban user.
     *
     */
    public function ban()
    {

        if ($this->hasRepliedMessage() && $this->isEnoughPrivileges()) {
            $kick = B::kickChatMember(
                [
                    "chat_id" => $this->e['chat_id'],
                    "user_id" => $this->e['reply_to']['from']['id']
                ]
            );
            $bannedUser = "<a href=\"tg://user?id=".$this->e['reply_to']['from']['id']."\">" . htmlspecialchars($this->e['reply_to']['from']['first_name'], ENT_QUOTES, 'UTF-8') . "</a>";
            if ($kick['info']['http_code'] === 200) {
                $msg = Lang::bind("{first_namelink}") . " banned ". $bannedUser."!";
                B::bg()::sendMessage(
                    [
                        "chat_id"    => $this->e['chat_id'],
                        "text"       => $msg,
                        "parse_mode" => "HTML"
                    ]
                );
            } else {
                B::bg()::sendMessage(
                    [
                        "chat_id"    => $this->e['chat_id'],
                        "text"       => "<code>".htmlspecialchars(json_decode($kick['content'], true)['description'], ENT_QUOTES, 'UTF-8')."</code>",
                        "parse_mode" => "HTML",
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                );
            }
            
        }
        return true;
    }


    /**
     * Kick user.
     *
     */
    public function kick()
    {

        if ($this->hasRepliedMessage() && $this->isEnoughPrivileges()) {
            $kick = B::kickChatMember(
                [
                    "chat_id" => $this->e['chat_id'],
                    "user_id" => $this->e['reply_to']['from']['id']
                ]
            );
            $bannedUser = "<a href=\"tg://user?id=".$this->e['reply_to']['from']['id']."\">" . htmlspecialchars($this->e['reply_to']['from']['first_name'], ENT_QUOTES, 'UTF-8') . "</a>";
            if ($kick['info']['http_code'] === 200) {
                B::unbanChatMember(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "user_id" => $this->e['reply_to']['from']['id']
                    ]
                );
                $msg = Lang::bind("{first_namelink}") . " kicked ". $bannedUser."!";
                B::bg()::sendMessage(
                    [
                        "chat_id"    => $this->e['chat_id'],
                        "text"       => $msg,
                        "parse_mode" => "HTML"
                    ]
                );
            } else {
                B::bg()::sendMessage(
                    [
                        "chat_id"    => $this->e['chat_id'],
                        "text"       => "<code>".htmlspecialchars(json_decode($kick['content'], true)['description'], ENT_QUOTES, 'UTF-8')."</code>",
                        "parse_mode" => "HTML",
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                );
            }
            
        }
        return true;
    }

    public function pin()
    {
        if ($this->hasRepliedMessage() && $this->isEnoughPrivileges()) {
            B::bg()::pinChatMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "message_id" => $this->e['reply_to']['message_id']
                ]
            );
        }
        return true;
    }

    public function promote()
    {
        if (in_array($this->e['user_id'], GLOBAL_ADMINS) || UserModel::isSudoer($this->e['user_id'])) {
            $a = B::promoteChatMember(
                [
                    "chat_id" => $this->e['chat_id'],
                    "user_id" => $this->e['reply_to']['from']['id']
                ]
            );
            if ($a['info']['http_code'] === 200) {
                B::bg()::sendMessage(
                    [
                        "text" => "<a href=\"tg://user?id=".$this->e['reply_to']['from']['id']."\">".htmlspecialchars($this->e['reply_to']['from']['first_name'])."</a> has been promoted to be an admin!",
                        "chat_id" => $this->e['chat_id'],
                        "reply_to_message_id" => $this->e['msg_id'],
                        "parse_mode" => "HTML"
                    ]
                );
            }
        }
        return true;
    }

    /**
     * Check the message has replied message or not.
     */
    private function hasRepliedMessage()
    {
        return ! empty($this->e['reply_to']);
    }

    /**
     * Check the sender has enough privilege to ban user or not.
     */
    private function isEnoughPrivileges()
    {
        return GroupModel::isAdmin($this->e['user_id'], $this->e['chat_id']);
    }
}
