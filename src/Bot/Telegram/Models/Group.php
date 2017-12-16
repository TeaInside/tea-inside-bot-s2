<?php

namespace Bot\Telegram\Models;

use DB;
use PDO;

class Group
{

	/**
	 * Check group is exists in database or not.
	 *
	 * @param string $groupId
	 * @return bool
	 */
	public static function groupExists($groupId)
	{
		$st = DB::prepare("SELECT `group_id` FROM `groups` WHERE `group_id`=:group_id LIMIT 1;");
		pc($st->execute([":group_id" => $groupId]), $st);
		return (bool) $st->fetch(PDO::FETCH_NUM);
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	public static function insertGroup($data)
	{
		$st = DB::prepare("INSERT INTO `groups` (`group_id`, `username`, `name`, `photo`, `private_link`, `creator`, `created_at`, `updated_at`) VALUES (:group_id,:username,:name,:photo,:private_link,:creator,:created_at,NULL);");
		pc($st->execute(
			$data = [
				":group_id" => $data['group_id'],
				":username" => (isset($data['username']) ? $data['username'] : null),
				":name"		=> $data['name'],
				":photo"	=> (isset($data['photo']) ? $data['photo'] : null),
				":private_link" => (isset($data['private_link']) ? $data['private_link'] : null),
				":creator"	=> (isset($data['creator']) ? $data['creator'] : null),
				":created_at" => (isset($data['created_at']) ? $data['created_at'] : date("Y-m-d H:i:s"))
			]
		), $st);
		unset($data[':creator']);
		$st = DB::prepare("INSERT INTO `group_history` (`group_id`, `username`, `name`, `photo`, `private_link`, `created_at`) VALUES (:group_id,:username,:name,:photo,:private_link,:created_at);");
		pc($st->execute($data), $st);
		$st = DB::prepare("INSERT INTO `group_settings` (`group_id`, `cycle`, `updated_at`) VALUES (:group_id, :cycle, NULL);");
		pc($st->execute(
			[
				":group_id" => $data[':group_id'],
				":cycle"	=> 1
			]
		), $st);
		return true;
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	public static function batchInsertAdmins($data)
	{
		if (is_array($data) && ! empty($data)) {
			$query = "INSERT INTO `group_admins` (`user_id`, `group_id`, `status`, `can_be_edited`, `can_change_info`, `can_delete_messages`, `can_invite_users`, `can_restrict_members`, `can_pin_messages`, `can_promote_members`, `created_at`) VALUES ";
			$bindValue['created_at'] = date("Y-m-d H:i:s");
			foreach ($data as $key => $val) {
				$query .= "(:user_id{$key},:group_id{$key},:status{$key},:can_be_edited{$key},:can_change_info{$key},:can_delete_messages{$key},:can_invite_users{$key},:can_restrict_members{$key},:can_pin_messages{$key},:can_promote_members{$key},:created_at),";
				$bindValue[':user_id'.$key] = $val['user_id'];
				$bindValue[':group_id'.$key]     = $val['group_id'];
				$bindValue[':status'.$key]        = $val['status'];
				$bindValue[':can_be_edited'.$key] = isset($val['can_be_edited']) ? (int) $val['can_be_edited'] : 1;
				$bindValue[':can_change_info'.$key] = isset($val['can_change_info']) ? (int) $val['can_change_info'] : 1;
				$bindValue[':can_delete_messages'.$key] = isset($val['can_delete_messages']) ? (int) $val['can_delete_messages'] : 1;
				$bindValue[':can_invite_users'.$key] = isset($val['can_invite_users']) ? (int) $val['can_invite_users'] : 1;
				$bindValue[':can_restrict_members'.$key] = isset($val['can_restrict_members']) ? (int) $val['can_restrict_members'] : 1;
				$bindValue[':can_pin_messages'.$key] = isset($val['can_pin_messages']) ? (int) $val['can_pin_messages'] : 1;
				$bindValue[':can_promote_members'.$key] = isset($val['can_promote_members']) ? (int) $val['can_promote_members'] : 1;
			}
			$st = DB::prepare($query = rtrim($query, ",").";");
			pc($st->execute($bindValue), $st);
			return true;
		}
		return false;
	}
}
