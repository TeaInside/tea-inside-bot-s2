<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/line/main.php";

$input = file_get_contents("php://input");

shell_exec(
    "/usr/bin/php " . __DIR__ . "/background.php \"" . urlencode($input) . "\" >> " . LINE_LOG_DIR . "/background.out 2>&1 &"
);