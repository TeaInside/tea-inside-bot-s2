<?php

namespace Bot\Telegram;

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

	public function buildEvent()
	{
	}

	/**
	 *
	 * @return bool
	 */
	public function run()
	{
	}
}