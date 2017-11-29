<?php

file_put_contents(TELEGRAM_LOG_DIR."/input.last", json_encode(json_decode($input), 128));
die(0);
