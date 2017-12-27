<?php

$ex = explode("\n", shell_exec("sudo ps aux | grep php"));
foreach ($ex as $val) {
	$val = trim($val);
	if (! empty($val)) {
		$val = explode(" ", $val, 7);
		if (isset($val[5])) {
			shell_exec("sudo renice -n -20 -p ".$val[5]." &");
		}
	}
}

