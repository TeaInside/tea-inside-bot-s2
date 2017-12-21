<?php

namespace Bot\Telegram\Contracts\Plugins;

interface MyAnimeListContract
{
	public function __construct($method, $parameter);

	public function get();
}