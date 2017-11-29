<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

shell_exec(
	"/usr/bin/php " . __DIR__ . "/background.php \"" . urlencode($input = file_get_contents("php://input")) . "\">> " . TELEGRAM_LOG_DIR . "/background.out 2>&1 &"
);

// debug input
require __DIR__ . "/debug.php";