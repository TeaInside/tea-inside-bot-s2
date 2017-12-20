<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class Group
{

    public static function isAdmin($user_id, $group_id)
    {
        if (in_array($user_id, GLOBAL_ADMINS)) {
            return true;
        }
        $st = DB::prepare("SELECT `user_id` FROM `group_admins` WHERE `group_id`=:group_id AND `user_id`=:user_id LIMIT 1;");
        pc($st->execute(
            [
                ":group_id" => $group_id,
                ":user_id"  => $user_id
            ]
        ), $st);
        return (bool) $st->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAdminInfo($userid, $group_id)
    {
        $st = DB::prepare("SELECT `user_id`, `group_id`, `status`, `can_be_edited`, `can_change_info`, `can_delete_messages`, `can_invite_users`, `can_restrict_members`, `can_pin_messages`, `can_promote_members` FROM `group_admins` WHERE `group_id`=:group_id AND `user_id`=:user_id LIMIT 1;");
        pc($st->execute(
            [
                ":group_id" => $group_id,
                ":user_id"  => $user_id
            ]
        ), $st);
        return $st->fetch(PDO::FETCH_ASSOC);
    }


    public static function setWelcome($welcome, $group_id)
    {
        $st = DB::prepare("UPDATE `group_settings` SET `welcome_message`=:welcome_message,`updated_at`=:updated_at WHERE `group_id`=:group_id LIMIT 1;");
        pc($st->execute(
            [
                ":welcome_message" => $welcome,
                ":updated_at" => date("Y-m-d H:i:s"),
                ":group_id"   => $group_id
            ]
        ), $st);
        return true;
    }

    public static function getSetting($group_id)
    {
        $st = DB::prepare("SELECT `group_id`, `cycle`, `welcome_message`, `max_warn`, `updated_at` FROM `group_settings` WHERE `group_id`=:group_id LIMIT 1;");
        $st->execute([":group_id" => $group_id]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public static function msgCount($group_id)
    {
        $st = DB::prepare("UPDATE `groups` SET `msg_count`=`msg_count`+1, `updated_at`=:updated_at WHERE `group_id`=:group_id LIMIT 1;");
        pc($st->execute(
            [
                ":updated_at" => date("Y-m-d H:i:s"),
                ":group_id"   => $group_id
            ]
        ), $st);
        return true;
    }

    public static function getInfo($value, $field = "group_id")
    {
        $st = DB::prepare("SELECT `group_id`,`username`,`name`,`photo`,`private_link`,`msg_count`,`creator` FROM `groups` WHERE `{$field}`=:bind LIMIT 1;");
        pc($st->execute([":bind"=>$value]), $st);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert($data)
    {
        $fx = function ($key, $default = null) use ($data) {
            return isset($data[$key]) ? $data[$key] : $default;
        };
        $st = DB::prepare("INSERT INTO `groups` (`group_id`, `username`, `name`, `photo`, `private_link`, `msg_count`, `creator`, `created_at`, `updated_at`) VALUES (:group_id, :username, :name, :photo, :private_link, :msg_count, :creator, :created_at, :updated_at);");
        pc($st->execute(
            $data = [
                ":group_id" => $fx("group_id"),
                ":username" => $fx("username"),
                ":name"         => $fx("name"),
                ":photo"    => $fx("photo"),
                ":private_link"     => $fx("private_link"),
                ":msg_count"    => $fx("msg_count", 1),
                ":creator"  => $fx("creator"),
                ":created_at"   => $fx("created_at", date("Y-m-d H:i:s")),
                ":updated_at"   => null
            ]
        ), $st);
        $st = DB::prepare("INSERT INTO `group_history` (`group_id`, `username`, `name`, `photo`, `private_link`, `created_at`) VALUES (:group_id, :username, :name, :photo, :private_link, :created_at);");
        unset($data[':msg_count'], $data[':creator'], $data[':updated_at']);
        pc($st->execute($data), $st);
        $st = DB::prepare("INSERT INTO `group_settings` (`group_id`, `cycle`, `welcome_message`, `max_warn`, `updated_at`) VALUES (:group_id, 1, NULL, 3, NULL);");
        pc($st->execute([":group_id" => $data[':group_id']]), $st);
        return true;
    }

    public static function insertAdmins($admins, $group_id)
    {
        $st = DB::prepare("INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `authority`, `is_bot`, `created_at`, `updated_at`) VALUES (:user_id, :username, :first_name, :last_name, :display_name, :photo, :authority, :is_bot, :created_at, :updated_at);");
        $stq = DB::prepare("INSERT INTO `user_history` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `created_at`) VALUES  (:user_id, :username, :first_name, :last_name, :display_name, :photo, :created_at);");
        $std = DB::prepare("INSERT INTO `group_admins` (`user_id`, `group_id`, `status`, `can_be_edited`, `can_change_info`, `can_delete_messages`, `can_invite_users`, `can_restrict_members`, `can_pin_messages`, `can_promote_members`, `created_at`) VALUES (:user_id, :group_id, :status, :can_be_edited, :can_change_info, :can_delete_messages, :can_invite_users, :can_restrict_members, :can_pin_messages, :can_promote_members, :created_at);");
        foreach ($admins as $key => $data) {
            $fx = function ($key, $default = null) use ($data) {
                return isset($data['user'][$key]) ? $data['user'][$key] : $default;
            };
            if ($st->execute(
                $dataq = [
                    ":user_id"  => $fx('user_id'),
                    ":username" => $fx('username'),
                    ":first_name"=> $fx('first_name'),
                    ":last_name"=> $fx('last_name'),
                    ":display_name"=> $fx('display_name'),
                    ":photo"=> $fx('photo'),
                    ":authority"=> $fx('authority', 'user'),
                    ":is_bot"=>(int)$fx('is_bot', 0),
                    ":created_at"=> $fx('created_at', date("Y-m-d H:i:s")),
                    ":updated_at" => null
                ]
            )) {
                unset($dataq[':authority'], $dataq[':is_bot'], $dataq[':updated_at']);
                pc($stq->execute($dataq), $stq);
            }
            $fx = function ($key, $default = null) use ($data) {
                return isset($data[$key]) ? $data[$key] : $default;
            };
            pc($std->execute(
                [
                    ":user_id" => $data['user']['id'],
                    ":group_id"     => $group_id,
                    ":status"   => $data['status'],
                    ":can_be_edited" => (int) $fx('can_be_edited',1),
                    ":can_change_info" => (int) $fx("can_change_info",1),
                    ":can_delete_messages" => (int) $fx("can_delete_messages",1),
                    ":can_invite_users"     => (int) $fx("can_invite_users", 1),
                    ":can_restrict_members"     => (int) $fx("can_restrict_members", 1),
                    ":can_pin_messages" => (int) $fx("can_pin_messages", 1),
                    ":can_promote_members"  => (int) $fx("can_promote_members"),
                    ":created_at"   => $fx("created_at", date("Y-m-d H:i:s"))
                ]
            ), $std);
        }
    }
}
