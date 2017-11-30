<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

/*$input = '{
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

$input = file_get_contents("php://input");

shell_exec(
    "/usr/bin/php " . __DIR__ . "/background.php \"" . urlencode($input) . "\" >> " . TELEGRAM_LOG_DIR . "/background.out 2>&1 &"
);

// debug input
require __DIR__ . "/debug.php";
