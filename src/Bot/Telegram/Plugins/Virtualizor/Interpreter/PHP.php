<?php

namespace Bot\Telegram\Plugins\Virtualizor\Interpreter;

use Curl\Curl;
use Bot\Telegram\Plugins\Virtualizor\Interpreter;

/**
* 
*/
class PHP extends Interpreter
{
	
	private $url;

	public function parse()
	{
		if (! defined("PHP_VIRTUALIZOR_DIR")) {
			throw new \Exception("PHP_VIRTUALIZOR_DIR is not defined", 1);
		}

		if (! defined("PHP_VIRTUALIZOR_URL")) {
			throw new \Exception("PHP_VIRTUALIZOR_URL is not defined", 1);
		}

		$dir = PHP_VIRTUALIZOR_DIR;
		$file = $dir."/".$this->hash.".php";
		if (! is_dir($dir)) {
			shell_exec("sudo mkdir -p ".$dir. " && sudo chmod -R 777 ".$dir);
			if (! is_dir($dir)) {
				throw new \Exception("Cannot create directory ".$dir);
			}
		}
		$handle = fopen($file, "w");
		flock($handle, LOCK_EX);
		fwrite($handle, $this->code);
		fflush($handle);
		fclose($handle);
		$this->url = PHP_VIRTUALIZOR_URL."/".$this->hash.".php";
	}

	public function isSecure()
	{
		return true;
	}

	public function exec()
	{
		$st = new Curl($this->url);
		$st->setOpt(
			[
				CURLOPT_TIMEOUT => 5,
				CURLOPT_CONNECTTIMEOUT => 5
			]
		);
		$out = $st->exec();
		if ($errno = $st->errno()) {
			$out = "Error ({$errno}): ".$this->error();
		}
		return $out;
	}
}

