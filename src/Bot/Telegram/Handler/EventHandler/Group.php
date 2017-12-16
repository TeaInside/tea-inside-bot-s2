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
			$this->insertNew();
		} else {
			if ($info = UserModel::getUserInfo($this->e['user_id'])) {
				User::trackUserHistory($info, 
							[
								"user_id"    	=> $this->e['user_id'],
								"first_name" 	=> $this->e['first_name'],
								"last_name"     => $this->e['last_name'],
								"display_name"	=> ($this->e['first_name'].(empty($this->e['last_name'])?"":" ".$this->e['last_name']),
								"username"  	=> $this->e['username'],
								"photo"			=> null
							]
				);
			} else {
				User::batchInsertUsers(
					[
						[
							"user_id"    => $this->e['user_id'],
							"first_name" => $this->e['first_name'],
							"last_name"  => $this->e['last_name'],
							"username"  => $this->e['username']
						]
					]
				);
			}
		}
		$this->saveEvent();
	}

	private function saveEvent()
	{
		$ins = "\\Bot\\Telegram\\Events\\GroupMessage\\";
		switch ($this->e['msg_type']) {
			case 'text':
				$ins .= "Text";
				break;
			
			default:
				# code...
				break;
		}
		$ins = new $ins($this->e);
		$ins->save();
	}

	private function insertNew()
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
		UserModel::batchInsertUsers(array_merge($users,
				[
					"user_id"    => $this->e['user_id'],
					"first_name" => $this->e['first_name'],
					"last_name"  => $this->e['last_name'],
					"username"  => $this->e['username']
				]
		));
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