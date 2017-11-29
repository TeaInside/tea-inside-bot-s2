<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

$app = new \Bot\Telegram\Bot(
		urldecode(
			json_decode(
				$argv[1]
			)
		)
	);
$app->buildEvent();
$app->run();
