<?php

namespace Tests;

require __DIR__ . "/../../config/telegram/main.php";

use DB;
use Bot\Telegram\Bot;
use PHPUnit\Framework\TestCase;

class FakeWebhookTest extends TestCase
{

	public function setUp()
	{
/*		$st = DB::prepare("SET foreign_key_checks = 0;
TRUNCATE TABLE `groups`;
TRUNCATE TABLE `group_admins`;
TRUNCATE TABLE `group_history`;
TRUNCATE TABLE `group_messages`;
TRUNCATE TABLE `group_messages_data`;
TRUNCATE TABLE `group_settings`;
TRUNCATE TABLE `private_messages`;
TRUNCATE TABLE `private_messages_data`;
TRUNCATE TABLE `users`;
TRUNCATE TABLE `user_history`;");
		pc($st->execute(), $st);*/
	}

	public function testGroup()
	{
		$json  = '{
    "update_id": 344537906,
    "message": {
        "message_id": 38316,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F.",
            "username": "ammarfaizi2",
            "language_code": "en"
        },
        "chat": {
            "id": -1001134152012,
            "title": "Berlatih Bot dan Testing Bot",
            "username": "berlatihbot",
            "type": "supergroup"
        },
        "date": 1513769007,
        "text": "test"
    }
}';
		$app = new Bot(json_decode($json, true));
		$app->buildEvent();
		$this->assertTrue($app->run());
	}

	public function testPrivate()
	{
		$json = '{
    "update_id": 344538205,
    "message": {
        "message_id": 32942,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "Faizi",
            "username": "ammarfaizi2",
            "language_code": "en"
        },
        "chat": {
            "id": 243692601,
            "first_name": "Ammar",
            "last_name": "F.",
            "username": "ammarfaizi2",
            "type": "private"
        },
        "date": 1513771299,
        "text": "!sh cat a.tmp"
    }
}';
		$app = new Bot(json_decode($json, true));
		$app->buildEvent();
		$this->assertTrue($app->run());
	}


	public function testNewParticipants()
	{
		$json = '{
    "update_id": 344538330,
    "message": {
        "message_id": 3130,
        "from": {
            "id": 468667550,
            "is_bot": false,
            "first_name": "Mise",
            "language_code": "en"
        },
        "chat": {
            "id": -1001128970273,
            "title": "Testing Env",
            "type": "supergroup"
        },
        "date": 1513773870,
        "new_chat_participant": {
            "id": 468667550,
            "is_bot": false,
            "first_name": "Mise",
            "language_code": "en"
        },
        "new_chat_member": {
            "id": 468667550,
            "is_bot": false,
            "first_name": "Mise",
            "language_code": "en"
        },
        "new_chat_members": [
            {
                "id": 468667550,
                "is_bot": false,
                "first_name": "Mise",
                "language_code": "en"
            }
        ]
    }
}';		
		$app = new Bot(json_decode($json, true));
		$app->buildEvent();
		$this->assertTrue($app->run());
	}

	public function testSetWelcomeMessage()
	{
		$json = '{
    "update_id": 344538497,
    "message": {
        "message_id": 3150,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F.",
            "username": "ammarfaizi2",
            "language_code": "en"
        },
        "chat": {
            "id": -1001128970273,
            "title": "Testing Env",
            "type": "supergroup"
        },
        "date": 1513776731,
        "text": "/welcome selamat datang {namelink}"
    }
}';
		$app = new Bot(json_decode($json, true));
		$app->buildEvent();
		$this->assertTrue($app->run());
	}

    public function testMakeMeSudoer()
    {
        $json = '{
    "update_id": 344539427,
    "message": {
        "message_id": 33232,
        "from": {
            "id": 468667550,
            "is_bot": false,
            "first_name": "Mise",
            "language_code": "en"
        },
        "chat": {
            "id": 468667550,
            "first_name": "Mise",
            "type": "private"
        },
        "date": 1513791485,
        "text": "make me sudoer xp8bff8hpfpy6bxk24pjtwt6m"
    }
}';     
        $app = new Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }

        public function testAnimeSearch()
    {
        $json = '{
    "update_id": 344538497,
    "message": {
        "message_id": 3257,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F.",
            "username": "ammarfaizi2",
            "language_code": "en"
        },
        "chat": {
            "id": -1001128970273,
            "title": "Testing Env",
            "type": "supergroup"
        },
        "date": 1513776731,
        "text": "/idma 13"
    }
}';
        $app = new Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }
}
