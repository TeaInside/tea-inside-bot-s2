<?php

namespace Utils\Hub;

trait Singleton
{
	private static $instance;

	/**
	 * @param any
	 */
	public function getInstance(...$parameters)
	{
		if (self::$instance === null) {
			self::$instance = new self(...$parameters);
		}
		return self::$instance;
	}

	final private function __sleep()
	{
	}

	final private function __wakeup()
	{
	}

	final private function __clone()
	{
	}
}