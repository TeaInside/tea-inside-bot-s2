<?php
require "config/telegram/main.php";
require "vendor/autoload.php";


$q = Telegram::getFile(
	[
		"file_id" => "AgADBQAD_qcxG84ZIVZuK_OWd8mcV0x90DIABGD1quU_xQzIkPUCAAEC"
	]
);


var_dump($q['content']);