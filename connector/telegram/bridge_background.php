<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/telegram/main.php";

Telegram::{urldecode($argv[1])}(...json_decode(urldecode($argv[2]),true));