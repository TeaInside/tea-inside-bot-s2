<?php

namespace Bot\Telegram\Lang\Data;

use Bot\Telegram\Lang\Data\EN;
use Bot\Telegram\Abstraction\Language as LanguageAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class EN extends LanguageAbstraction
{
	public static $map = [
		"start" => EN\Start::class
	];
}
