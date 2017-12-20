<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/line/main.php";

$app = new \Bot\LINE\Bot(
    json_decode(
        urldecode(
            $argv[1]
        ),
        true
    )
);
$app->buildEvent();
$app->run();
