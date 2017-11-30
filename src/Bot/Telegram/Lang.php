<?php

namespace Bot\Telegram;

use Utils\Hub\Singleton;
use Bot\Telegram\Events\User;
use Bot\Telegram\Lang\Binding;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Lang
{
	use Singleton;

	/**
	 * @var \Bot\Telegram\Lang\Binding
	 */
	private $binder;

	/**
	 * Constructor.
	 *
	 *
	 * @param \Bot\Telegram\Events\User $user
	 */
	public function __construct(User $user)
	{
		$this->binder = new Binding($user);
	}

	/**
	 * Build self instance.
	 *
	 *
	 * @param \Bot\Telegram\Events\User $user
	 */
	public static function build(User $user)
	{
		self::getInstance($user);
	}

	/**
	 * Bind text.
	 *
	 * @param string $key
	 * @param string $lang
	 * @return string
	 */
	public static function bind($key, $lang = null)
	{
		
	}
}