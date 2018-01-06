<?php

namespace Bot\LINE\Abstraction;

use Bot\LINE\Bot;

abstract class CommandFoundation
{
	/**
	 * @var array
	 */
	protected $b = [];

	/**
	 *
	 * @param array $data
	 */
	public function __construct($data)
	{
		$this->b = $data;
	}
}