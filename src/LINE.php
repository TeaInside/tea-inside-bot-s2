<?php

use Stacks\LINE\BackgroundProcess;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @package LINE
 */
class LINE
{
	public static function bg()
	{
		return new BackgroundProcess;
	}
}