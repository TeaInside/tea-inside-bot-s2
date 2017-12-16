<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class User
{

	public static function getUserInfo($userId)
	{
		$st = DB::prepare("SELECT `user_id`,`username`,`first_name`,`last_name`,`display_name`,`photo` FROM `users` WHERE `user_id`=:user_id LIMIT 1;");
		pc($st->execute([":user_id" => $userId]), $st);
		return $st->fetch(PDO::FETCH_ASSOC);
	}


	public static function trackUserHistory($old, $new)
	{
		$changed = [];
		if ($old['display_name'] !== $new['display_name']) {
			$changed[] = "display_name";
		} else ($old['username'] !== $new['username']) {
			$changed[] = "username";
		}
		foreach ($changed as $k => $v) {
			switch ($v) {
				case 'display_name':
					// send notify
					break;
				case 'username':
					// send notify
					break;
				default:
					break;
			}
		}
		if (sizeof($changed)) {
			$st = DB::prepare("INSERT INTO `user_history` (`user_id`, `first_name`, `last_name`, `display_name`, `photo`, `created_at`) VALUES (:user_id, :first_name, :last_name, :display_name, :photo, :datee);");
			pc($st->execute($data = array_merge($new, [":datee" => date("Y-m-d H:i:s")])), $st);
			$st = DB::prepare("UPDATE `users` SET `first_name`=:first_name,`last_name`=:last_name,`display_name`=:display_name,`photo`=:photo,`updated_at`=:datee WHERE `user_id`=:user_id LIMIT 1;");
			pc($st->execute($data), $st);
		}
	}

	/**
	 * @param array $data
	 */
	public static function batchInsertUsers($data)
	{
		if (is_array($data) && ! empty($data)) {
			$query = "INSERT IGNORE INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `display_name`, `photo`, `authority`, `is_bot`, `created_at`, `updated_at`) VALUES ";
			$bindValue = [];
			$bindValue[':created_at'] = date("Y-m-d H:i:s");
			foreach ($data as $key => $val) {
				$query .= "(:user_id{$key}, :username{$key}, :first_name{$key}, :last_name{$key}, :display_name{$key}, :photo{$key}, :authority{$key}, :is_bot{$key}, :created_at, NULL),";
				$bindValue[':user_id'.$key]      = isset($val['user_id']) ? $val['user_id'] : $val['id'];
				$bindValue[':username'.$key]     = (
					isset($val['username']) ? $val['username'] : (
						isset($val['uname']) ? $val['uname'] : null
					));
				$bindValue[':first_name'.$key]   = isset($val['first_name']) ? $val['first_name'] : null;
				$bindValue[':last_name'.$key]    = isset($val['last_name']) ? $val['last_name'] : null;
				$bindValue[':display_name'.$key] = (
						isset($val['display_name']) ? $val['display_name'] : (
							isset($val['last_name']) ? (
								$val['first_name'] . " " . $val['last_name']
							) : $val['first_name']
						)
					);
				$bindValue[':photo'.$key]        = isset($val['photo']) ? $val['photo'] : null;
				$bindValue[':authority'.$key]    = isset($val['authority']) ? $val['authority'] : 'user';
				$bindValue[':is_bot'.$key] = (
						isset($val['is_bot']) ? (
							(bool) $val['is_bot'] ? 1 : 0
						) : 0
					);
			}
			$st = DB::prepare($query = rtrim($query, ",").";");
			pc($st->execute($bindValue), $st);
			return true;
		}
	}
}