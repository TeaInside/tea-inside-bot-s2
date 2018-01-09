<?php

namespace Tests\LINE;

require __DIR__ . "/../../config/line/main.php";

use PHPUnit\Framework\TestCase;

class FakeWebhookTest extends TestCase
{
    public function testSticker()
    {
        $json = '{
    "events": [
        {
            "type": "message",
            "replyToken": "a4d7042cdfcb4e2a86a6f3a671e4f23e",
            "source": {
                "groupId": "Ce20228a1f1f98e6cf9d6f6338603e962",
                "userId": "U547ba62dc793c6557abbb42ab347f15f",
                "type": "group"
            },
            "timestamp": 1515477510703,
            "message": {
                "type": "sticker",
                "id": "7281400575767",
                "stickerId": "10",
                "packageId": "1"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }

    public function testPrivateChat()
    {
        $json = '{
    "events": [
        {
            "type": "message",
            "replyToken": "8630d07f27cb487780488234f5e02d52",
            "source": {
                "userId": "U547ba62dc793c6557abbb42ab347f15f",
                "type": "user"
            },
            "timestamp": 1515192523130,
            "message": {
                "type": "text",
                "id": "7263900060953",
                "text": "/tl id en selamat pagi"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }

    public function testGroupChat()
    {
        $json = '{
    "events": [
        {
            "type": "message",
            "replyToken": "c288dc8b349e4effae573ed94d0fc751",
            "source": {
                "groupId": "Ce20228a1f1f98e6cf9d6f6338603e962",
                "userId": "U547ba62dc793c6557abbb42ab347f15f",
                "type": "group"
            },
            "timestamp": 1515205758062,
            "message": {
                "type": "text",
                "id": "7264596347061",
                "text": "Gayenk"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }

    public function testImage()
    {
        $json = '{
    "events": [
        {
            "type": "message",
            "replyToken": "b052c18d89fb4d489d57a014bc9b2f84",
            "source": {
                "userId": "U547ba62dc793c6557abbb42ab347f15f",
                "type": "user"
            },
            "timestamp": 1515206106069,
            "message": {
                "type": "image",
                "id": "7264617930218"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());


        $json = '{
    "events": [
        {
            "type": "message",
            "replyToken": "763a51e9bc9f46e490140cf1d107de64",
            "source": {
                "groupId": "Ce20228a1f1f98e6cf9d6f6338603e962",
                "userId": "U547ba62dc793c6557abbb42ab347f15f",
                "type": "group"
            },
            "timestamp": 1515212075926,
            "message": {
                "type": "image",
                "id": "7265014684335"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }
}