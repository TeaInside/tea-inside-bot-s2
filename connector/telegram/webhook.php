<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

$input = '{
    "update_id": 952238814,
    "message": {
        "message_id": 719,
        "from": {
            "id": 243692601,
            "is_bot": false,
            "first_name": "Ammar",
            "last_name": "F.",
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
        "date": 1511959575,
        "text": "test"
    }
}';

print "/usr/bin/php " . __DIR__ . "/background.php \"" . urlencode($input) . "\" >> " . TELEGRAM_LOG_DIR . "/background.out 2>&1 &";

// $input = file_get_contents("php://input");

shell_exec(
	"/usr/bin/php " . __DIR__ . "/background.php \"" . urlencode($input) . "\">> " . TELEGRAM_LOG_DIR . "/background.out 2>&1 &"
);

// debug input
require __DIR__ . "/debug.php";