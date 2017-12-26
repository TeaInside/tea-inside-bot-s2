<?php

namespace Bot\Telegram\Plugins\Virtualizor\Compiler;

use Bot\Telegram\Plugins\Virtualizor\Compiler;

/**
* 
*/
class Cpp extends Compiler
{
	public $file;

	public $binFile;

	public $needCompiler = false;

	public $compileOk = true;

	public $error;

	public function parse()
	{
		if (! defined("CPP_VIRTUALIZOR_DIR")) {
			throw new \Exception("CPP_VIRTUALIZOR_DIR is not defined", 1);
		}

		$dir = CPP_VIRTUALIZOR_DIR;
		$this->file		 = $file = $dir."/code/".$this->hash.".cpp";
		$this->binFile	 = $dir."/bin/".$this->hash;
		is_dir($dir) or shell_exec("sudo mkdir -p ".$dir);
		is_dir($dir."/code") or shell_exec("sudo mkdir -p ".$dir."/code");
		is_dir($dir."/bin") or shell_exec("sudo mkdir -p ".$dir."/bin");
		if (! file_exists($dir."/bin/".$this->hash) or ! is_executable($dir."/bin/".$this->hash)) {
			shell_exec("sudo chmod 777 ".$dir);
			shell_exec("sudo chmod 777 ".$dir."/bin");
			shell_exec("sudo chmod 777 ".$dir."/code");
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
			$compile = trim(shell_exec("c++ ".$this->file." -o ".$this->binFile." 2>&1 && echo \"compile success {$uniq}\""));

			if (strpos($compile, "compile success {$uniq}") === false) {
				$this->compileOk = false;
			} else {
				$this->error = $compile;
			}
		}
	}

	public function exec()
	{
		if (! $this->compileOk) {
			return $this->error;
		} else {
			return file_exists($this->binFile) ? shell_exec($this->binFile." 2>&1") : "Error";
		}
	}
}
