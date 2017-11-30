<?php

namespace Bot\Telegram\Lang\Data;

use Bot\Telegram\Lang\Data\ID;
use Bot\Telegram\Abstraction\Language as LanguageAbstraction;

class ID extends LanguageAbstraction
{
	public static $map = [
		"start" => ID\Start::class
	];
}
