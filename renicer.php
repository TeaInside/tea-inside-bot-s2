<?php

$ex = explode("\n", shell_exec("sudo ps aux | grep php"));

foreach ($ex as $val) {
	$val = trim($val);
	if (! empty($val)) {
		do {
			$val = str_replace("  ", " ", $val, $n);
		} while ($n);
		$val = explode(" ", $val, 3);
		if (isset($val[1])) {
			shell_exec("sudo renice -n -20 -p ".$val[1]." &");
		}
	}
}
