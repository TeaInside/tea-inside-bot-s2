<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class User
{
    public static function addSudoer($user_id)
    {
        $st = DB::prepare($q = "UPDATE `users` SET `authority`='superuser' WHERE `user_id`={$user_id} LIMIT 1");
        pc($st->execute(), $st);
        return true;
    }

    public static function getSudoers()
    {
        $sudoers = SUDOERS;
        $st = DB::prepare("SELECT `user_id` FROM `users` WHERE `authority`='superuser';");
        pc($st->execute(), $st);
        while ($q = $st->fetch(PDO::FETCH_NUM)) {
            $sudoers[] = $q[0];
        }
        return $sudoers;
    }

    public static function isSudoer($user_id)
    {
        if (in_array($user_id, SUDOERS)) {
            return true;
        }
        $st = DB::prepare("SELECT `authority` FROM `users` WHERE `user_id`=:user_id LIMIT 1;");
        pc($st->execute([":user_id" => $user_id]), $st);
        $st = $st->fetch(PDO::FETCH_NUM);
        return $st and $st[0] === "superuser";
    }

    public static function getInfo($val, $field = "user_id")
    {
        $st = DB::prepare("SELECT `user_id`,`username`,`first_name`,`last_name`,`display_name`,`photo`,`authority`,`is_bot`,`has_private_message` FROM `users` WHERE `{$field}`=:bind LIMIT 1;");
        pc($st->execute([":bind" => $val]), $st);
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($data, $historyTrack = 0)
    {
        $fx = function ($key, $default = null) use ($data) {
            return isset($data[$key]) ? $data[$key] : $default;
        };
        $st = DB::prepare("UPDATE `users` SET `username`=:username, `first_name`=:first_name, `last_name`=:last_name, `display_name`=:display_name, `has_private_message`=:has_private_message, `authority`=:authority, `photo`=:photo,`updated_at`=:updated_at WHERE `user_id`=:user_id LIMIT 1;");
        pc($st->execute(
            $dataq = [
                ":username" => $fx('username'),
                ":first_name" => $fx('first_name'),
                ":last_name"  => $fx('last_name'),
                ":display_name"=> $fx('display_name'),
                ":has_private_message" => $fx('has_private_message', 0),
                ':authority' => $fx('authority', 'user'),
                ":photo"     => $fx('photo'),
                ":updated_at" => $fx('updated_at', date("Y-m-d H:i:s")),
                ":user_id"  => $fx("user_id")
            ]
        ), $st);
        if ($historyTrack) {
            $st = DB::prepare("INSERT INTO `user_history` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `created_at`) VALUES  (:user_id, :username, :first_name, :last_name, :display_name, :photo, :created_at);");
            $dataq[":created_at"] = date("Y-m-d H:i:s");
            unset($dataq[':authority'], $dataq[':is_bot'], $dataq[':updated_at'], $dataq[':has_private_message']);
            pc($st->execute($dataq), $st);
        }
    }

    public static function insert($data)
    {
        $fx = function ($key, $default = null) use ($data) {
            return isset($data[$key]) ? $data[$key] : $default;
        };
        $st = DB::prepare("INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `authority`, `is_bot`, `has_private_message`,`created_at`, `updated_at`) VALUES (:user_id, :username, :first_name, :last_name, :display_name, :photo, :authority, :is_bot, :has_private_message, :created_at, :updated_at);");
        pc($st->execute(
            $data = [
                ":user_id"  => $fx('user_id'),
                ":username" => $fx('username'),
                ":first_name"=> $fx('first_name'),
                ":last_name"=> $fx('last_name'),
                ":display_name"=> $fx('display_name'),
                ":photo"=> $fx('photo'),
                ":authority"=> $fx('authority', 'user'),
                ":is_bot"=>$fx('is_bot', 0),
                ":created_at"=> $fx('created_at', date("Y-m-d H:i:s")),
                ":has_private_message" => $fx("has_private_message", 0),
                ":updated_at" => null
            ]
        ), $st);
        $st = DB::prepare("INSERT INTO `user_history` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `created_at`) VALUES  (:user_id, :username, :first_name, :last_name, :display_name, :photo, :created_at);");
        unset($data[':authority'], $data[':is_bot'], $data[':updated_at'], $data[':has_private_message']);
        pc($st->execute($data), $st);
        return true;
    }
}
