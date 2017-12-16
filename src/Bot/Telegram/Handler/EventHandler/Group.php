<?php

namespace Bot\Telegram\Handler\EventHandler;

use Telegram as B;
use Bot\Telegram\Abstraction\EventHandler;
use Bot\Telegram\Models\User as UserModel;
use Bot\Telegram\Models\Group as GroupModel;

class Group extends EventHandler
{
	public function run()
	{
		if (! GroupModel::groupExists($this->e['chat_id'])) {
			$this->insert();
		}
	}

	private function insert()
	{
		$a = B::getChatAdministrators(["chat_id" => $this->e['chat_id']]);
		if ($a['info']['http_code'] != 200) {
			return false;
		}
		$a = json_decode($a['content'], true);
		$users = $admins = [];
		$creator = null;
		foreach ($a['result'] as $key => $val) {
			$users[$key]  = $val['user'];
			if ($val['status'] === "creator") {
				$admins[$key] = [
					"user_id" => ($creator = $val['user']['id']),
					"group_id"=> $this->e['chat_id'],
					"status"  => "creator"
				];
			} else {
				$admins[$key] = [
					"user_id" => $val['user']['id'],
					"group_id"=> $this->e['chat_id'],
					"status"  => $val['status']
				];
				unset($val['user']);
				$admins[$key] = array_merge($admins[$key], $val);
			}
		}
		UserModel::batchInsertUsers($users);
		GroupModel::insertGroup(
			[
				"group_id" => $this->e['chat_id'],
				"username" => $this->e['chatuname'],
				"name"	   => $this->e['chattitle'],
				"photo"	   => null,
				"private_link" => null,
				"creator"  => $creator
			]
		);
		GroupModel::batchInsertAdmins($admins);
	}
}