<?php

file_put_contents(LINE_LOG_DIR."/input.last", json_encode(json_decode($input), 128));
die(0);
