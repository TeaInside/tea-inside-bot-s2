<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class User
{
	public static function getInfo($val, $field = "user_id")
	{
		$st = DB::prepare("SELECT `user_id`,`username`,`first_name`,`last_name`,`display_name`,`photo`,`authority`,`is_bot`,`has_private_message` FROM `users` WHERE `{$field}`=:bind LIMIT 1;");
		pc($st->execute([":bind" => $val]), $st);
		return $st->fetch(PDO::FETCH_ASSOC);
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
		unset($data[':authority'], $data[':is_bot'], $data[':updated_at']);
		pc($st->execute($data), $st);
		return true;
	}
}
