<?php

namespace Stacks\Telegram;

use Telegram as B;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @package Telegram
 */
class BackgroundProcess
{
	/**
     * @param string $method
     * @param array  $parameters
     * @return array
     */
	public function __call($method, $parameters)
	{
		shell_exec(
			PHP_BINARY . " " . BASEPATH . "/connector/telegram/bridge_background.php " . urlencode($method) . " \"" . urlencode(json_encode($parameters)) . "\" >> /dev/null 2>&1 &"
		);
		return true;
	}

	/**
	 * Prevent set property.
	 */
	private function __set()
	{
	}
}
