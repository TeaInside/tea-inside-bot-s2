<?php

require __DIR__ . "/../../vendor/autoload.php";

shell_exec(
	"/usr/bin/php background.php \"".urlencode(file_get_contents("php://input"))."\">> ".TELEGRAM_LOG_DIR."/background.out 2>&1 &"
);
