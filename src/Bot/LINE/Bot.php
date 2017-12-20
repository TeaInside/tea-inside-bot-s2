<?php

namespace Bot\LINE;

class Bot
{
	/**
	 * @var array
	 */
	private $input = [];

	/**
	 * Constructor.
	 *
	 * @param array $input
	 */
	public function __construct($input)
	{
		$this->input = $input;
	}

	public function buildContext()
	{
	}

	public function run()
	{
	}
}