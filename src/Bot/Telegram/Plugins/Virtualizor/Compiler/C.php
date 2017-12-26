<?php

namespace Bot\Telegram\Plugins\Virtualizor\Compiler;

use Bot\Telegram\Plugins\Virtualizor\Compiler;

/**
* 
*/
class C extends Compiler
{
	public $file;

	public $binFile;

	public $needCompiler = false;

	public $compileOk = true;

	public $error;

	public function parse()
	{
		if (! defined("C_VIRTUALIZOR_DIR")) {
			throw new \Exception("C_VIRTUALIZOR_DIR is not defined", 1);
		}

		$dir = C_VIRTUALIZOR_DIR;
		$this->file		 = $file = $dir."/code/".$this->hash.".c";
		$this->binFile	 = $dir."/bin/".$this->hash;
		is_dir($dir) or shell_exec("sudo mkdir -p ".$dir);
		is_dir($dir) or shell_exec("sudo mkdir -p ".$dir."/code");
		is_dir($dir) or shell_exec("sudo mkdir -p ".$dir."/bin");
		if (! file_exists($dir."/bin/".$this->hash) or ! is_executable($dir."/bin/".$this->hash)) {
			$handle = fopen($this->file, "w");
			flock($handle, LOCK_EX);
			fwrite($handle, $this->code);
			fflush($handle);
			fclose($handle);
			$this->needCompiler = true;
		}
	}

	public function isSecure()
	{
		return true;
	}

	public function compile()
	{
		if ($this->needCompiler) {
			$uniq = sha1(time());
			$compile = trim(shell_exec("g++ ".$this->file." -o ".$this->binFile." 2>&1 && echo \"compile success {$uniq}\""));

			if (strpos($uniq, "compile success {$uniq}") === false) {
				$this->compileOk = false;
			} else {
				$this->error = $compile;
			}
		}
	}

	public function exec()
	{
		if ($this->error) {
			return $error;
		} else {
			return shell_exec($this->binFile." 2>&1");
		}
	}
}
