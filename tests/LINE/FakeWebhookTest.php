<?php

namespace Tests\LINE;

class FakeWebhookTest extends TestCase
{
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
                "text": "Test"
            }
        }
    ]
}';
        $app = new \Bot\LINE\Bot(json_decode($json, true));
        $app->buildEvent();
        $this->assertTrue($app->run());
    }
}