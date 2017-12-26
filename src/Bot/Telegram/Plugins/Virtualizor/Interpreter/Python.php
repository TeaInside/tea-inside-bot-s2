<?php

namespace Bot\Telegram\Plugins\Virtualizor\Interpreter;

use Bot\Telegram\Plugins\Virtualizor\Interpreter;

/**
* 
*/
class Python extends Interpreter
{
	
	private $url;

	public $file;

	public function parse()
	{
		if (! defined("PYTHON_VIRTUALIZOR_DIR")) {
			throw new \Exception("PYTHON_VIRTUALIZOR_DIR is not defined", 1);
		}

		$dir = PYTHON_VIRTUALIZOR_DIR;
		$this->file = $file = $dir."/".$this->hash.".js";
		if (! is_dir($dir)) {
			shell_exec("sudo mkdir -p ".$dir. " && sudo chmod -R 777 ".$dir);
			if (! is_dir($dir)) {
				throw new \Exception("Cannot create directory ".$dir);
			}
		}
		if (! file_exists($this->file)) {
			$handle = fopen($file, "w");
			flock($handle, LOCK_EX);
			fwrite($handle, $this->code);
			fflush($handle);
			fclose($handle);
		}
	}

	public function isSecure()
	{
		return true;
	}

	public function exec()
	{
		return shell_exec("python3 ".$this->file." 2>&1");
	}
}