<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/line/main.php";

LINE::{urldecode($argv[1])}(...json_decode(urldecode($argv[2]), true));
