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
		/*		$json = 
		'{
		    "update_id": 952238819,
		    "message": {
		        "message_id": 2592,
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
		        "date": 1511961011,
		        "reply_to_message": {
		            "message_id": 2588,
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
		            "date": 1511960832,
		            "text": "ping"
		        },
		        "text": "/start"
		    }
		}';*/
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
}
