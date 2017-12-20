<?php

namespace Bot\LINE\Events;

use ArrayAccess;

class EventRecognizer implements ArrayAccess
{
	public function __construct($input)
	{
		$this->input = $input;
	}

	/**
	 * @param string|int $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : false;
	}

	/**
	 * @param string|int $offset
	 * @param any		 $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->container[$offset] = $value;
	}

	/**
	 * @param string|int $offset
	 * @return bool
	 */
	public function offsetIsset($offset)
	{
		return isset($this->container[$offset]);
	}

	/**
	 * @param string|int $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->container[$offset]);
	}
}