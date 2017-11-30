<?php

namespace Bot\Telegram;

use Utils\Hub\Singleton;
use Bot\Telegram\Lang\Map;
use Bot\Telegram\Events\User;
use Bot\Telegram\Lang\Binding;
use Bot\Telegram\Events\EventRecognition as Event;

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
	 * @var string
	 */
	private $lang;

	/**
	 * Constructor.
	 *
	 *
	 * @param \Bot\Telegram\Events\User $user
	 * @param \Bot\Telegram\Events\EventRecognition
	 */
	public function __construct(User $user, Event $event)
	{
		$this->lang   = $user['lang'];
		$this->binder = new Binding($user, $event);
	}

	/**
	 * Build self instance.
	 *
	 *
	 * @param \Bot\Telegram\Events\User $user
	 * @param \Bot\Telegram\Events\EventRecognition
	 */
	public static function build(User $user, Event $event)
	{
		self::getInstance($user, $event);
	}

	/**
	 * Bind text.
	 *
	 * @param string $string
	 * @param string $lang
	 * @return string
	 */
	public static function bind($string, $lang = null)
	{
		return self::getInstance()->binder->bind($string);
	}

	/**
	 *
	 * @param string $key
	 * @return string
	 */
	public static function get($key)
	{
		$ins = self::getInstance();
		if (isset(Map::$map[$ins->lang])) {
			$class = isset(Map::$map[$ins->lang][0]::$map[$key]) ? Map::$map[$ins->lang][0]::$map[$key] : Map::$map[$ins->lang][0]::$map[$key];
		} else {
			$class = Map::$map[$ins->lang][0]::$map[$key];
		}
		if (is_array($class::$text)) {
			return self::bind($class::$text[rand(0, count($class::$text) - 1)]);
		} else {
			return self::bind($class::$text);
		}
	}
}