<?php

namespace Tests;

require __DIR__ . "/../../config/telegram/main.php";

use Bot\Telegram\Bot;
use PHPUnit\Framework\TestCase;

class FakeWebhookTest extends TestCase
{

	public function setUp()
	{
/*		$this->json = 
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
		$this->json  = '{
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
	}

	public function testGroup()
	{
		$app = new Bot(json_decode($this->json, true));
		$app->buildEvent();
		$this->assertTrue($app->run());
	}
}
