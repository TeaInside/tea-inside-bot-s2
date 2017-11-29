<?php

namespace Bot\Telegram;

use Bot\Telegram\Events\EventRecognition;

final class Bot
{

	/**
	 * @var array
	 */
	public $input = [];

	/**
	 * Constructor.
	 *
	 * @param array $input
	 */
	public function __construct($input)
	{
		$this->input = $input;
	}

	/**
	 * Build current event.
	 */
	public function buildEvent()
	{
		$this->input = new EventRecognition($this->input);
	}

	/**
	 *
	 * @return bool
	 */
	public function run()
	{
	}
}