<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class Group
{
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
		$st->execute(
			$data = [
				":group_id" => $fx("group_id"),
				":username" => $fx("username"),
				":name"		=> $fx("name"),
				":photo"	=> $fx("photo"),
				":private_link"	=> $fx("private_link"),
				":msg_count"	=> $fx("msg_count", 1),
				":creator"	=> $fx("creator"),
				":created_at"	=> $fx("created_at", date("Y-m-d H:i:s")),
				":updated_at"	=> null
			]
		);
		$st = DB::prepare("INSERT INTO `group_history` (`group_id`, `username`, `name`, `photo`, `private_link`, `created_at`) VALUES (:group_id, :username, :name, :photo, :private_link, :created_at);");
		unset($data[':msg_count'], $data[':creator'], $data[':updated_at']);
		pc($st->execute($data), $st);
		return true;
	}

	public static function insertAdmin($admins, $group_id)
	{
		foreach ($admins as $key => $data) {
			$fx = function ($key, $default = null) use ($data) {
				return isset($data[$key]) ? $data[$key] : $default;
			};
			$st = DB::prepare("INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `authority`, `is_bot`, `created_at`, `updated_at`) VALUES (:user_id, :username, :first_name, :last_name, :display_name, :photo, :authority, :is_bot, :created_at, :updated_at);");
			if ($st->execute(
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
					":updated_at" => null
				]
			)) {
				$st = DB::prepare("INSERT INTO `user_history` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `created_at`) VALUES  (:user_id, :username, :first_name, :last_name, :display_name, :photo, :created_at);");
				unset($data[':authority'], $data[':is_bot'], $data[':updated_at']);
				pc($st->execute($data), $st);
			}
		}
	}
}