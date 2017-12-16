<?php

namespace Bot\Telegram\Models;

use DB;

class User
{
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