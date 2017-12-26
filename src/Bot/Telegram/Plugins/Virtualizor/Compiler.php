<?php

namespace Bot\Telegram\Plugins\Virtualizor;

abstract class Compiler
{
	protected $code;

	protected $hash;

	public function __construct($code)
	{
		$this->code = $code;
		$this->hash = sha1($code);
	}

	abstract public function parse();

	abstract public function compile();

	abstract public function isSecure();

	abstract public function exec();

	final public function execute()
	{
		$this->parse();
		if ($this->isSecure()) {
			$this->compile();
			return $this->exec();
		}
	}
}
