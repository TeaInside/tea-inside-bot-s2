<?php

file_put_contents(LOG_DIR."/telegram/input.last", json_encode(json_decode($input), 128));
die(0);