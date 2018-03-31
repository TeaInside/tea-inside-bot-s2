<?php

namespace Bot\Telegram\Plugins\GoogleTranslate;

use Bot\Telegram\Contracts\PluginContract;
use GoogleTranslate\GoogleTranslate as GoogleTranslateFoundation;

class GoogleTranslate implements PluginContract
{

	/**
	 * @var array
	 */
	private $result = [];

	/**
	 * Constructor.
	 *
	 * @param string $method
	 * @param string $parameter
	 */
	public function __construct($text, $from, $to)
	{
		$a = new GoogleTranslateFoundation($text, $from, $to);
		$this->result = $a->exec();
	}

	/**
	 * @return array
	 */
	public function get()
	{
		return $this->result;
	}
}
