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
		file_put_contents(LINE_LOG_DIR."/input.last", json_encode($this->input, 128));
	}

	public function buildContext()
	{
	}

	public function run()
	{
	}
}