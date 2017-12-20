<?php

namespace Bot\Telegram\Handler\Events\GroupMessage;

use DB;
use Bot\Telegram\Handler\Events\SaveEvent;

class Text extends SaveEvent
{
	public function run()
	{
		$st = DB::prepare("");
	}
}