<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

$app = new \Bot\Telegram\Bot(
		json_decode(
			urldecode(
				$argv[1]
			),
			true
		)
	);
$app->buildEvent();
$app->run();
