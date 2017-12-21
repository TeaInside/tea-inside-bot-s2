<?php

namespace Bot\Telegram\Plugins\MyAnimeList;

use Bot\Telegram\Contracts\PluginContract;
use MyAnimeList\MyAnimeList as MyAnimeListFoundation;
use Bot\Telegram\Contracts\Plugins\MyAnimeListContract;

class MyAnimeList implements PluginContract, MyAnimeListContract
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
	public function __construct($method, $paramter)
	{
		$this->result = MyAnimeListFoundation::{$method}($paramter);
	}

	/**
	 * @return array
	 */
	public function get()
	{
		return $this->result;
	}
}
