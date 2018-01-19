<?php

namespace Bot\Telegram\Plugins\Youtube;

use Bot\Telegram\Contracts\PluginContract;
use YoutubeDownloader\Youtube as YoutubeDownloaderFoundation;

class YoutubeDownloader implements PluginContract
{

	/**
	 * @var \Youtube\Youtube
	 */
	private $st;

	/**
	 * @param string $link
	 */
	public function __construct($link)
	{
		$this->st = new YoutubeDownloaderFoundation($link);
	}

	public function __call($method, $parameters)
	{
		return $this->st->{$method}(...$parameters);
	}
}
