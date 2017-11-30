<?php

namespace Bot\Telegram\Lang;

use Bot\Telegram\Events\User;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Binding
{
	/**
	 * @var \Bot\Telegram\Events\User
	 */
	private $user;

	/**
	 * Constructor.
	 *
	 * @param \Bot\Telegram\Events\User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Bind text.
	 *
	 * @param string $text
	 */
	public function bind($text)
	{
		return str_replace($this->replacer[0], $this->replacer[1], $text);
	}
}