<?php

namespace Bot\Telegram\Plugins\WhatAnime;

use Bot\Telegram\Contracts\PluginContract;
use WhatAnime\WhatAnime as WhatAnimeFoundation;

class WhatAnime implements PluginContract
{

	/**
	 * @var array
	 */
	private $result = [];

	/**
	 * @param string $file Binary file
	 */
	public function __construct($file)
	{
		$st = new WhatAnimeFoundation($file);
		$this->result['data'] = $st->getFirst();
		$this->result['video_url'] = $st->getVideo();
	}

	public function get()
	{
		return $this->result;
	}
}
