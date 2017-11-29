<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @package Telegram
 */

class Telegram
{	
	/**
	 * @param string $method
	 * @param array  $parameters
	 * @return array
	 */
	public static function __callStatic($method, $parameters)
	{
		if (isset($parameters[1]) && $parameters[1] === "GET") {
			$ch = curl_init("https://api.telegram.org/bot".TOKEN."/".$method."?".http_build_query($method));
			$opt = [
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false
			];
		} else {
			$ch = curl_init("https://api.telegram.org/bot".TOKEN."/".$method);
			$opt = [
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_POST => true
			];
			if (is_array($parameters[0])) {
				if (isset($parameters[2]) && $parameters[2] === "no_query") {
					$opt[CURLOPT_POSTFIELDS] = $parameters[0];
				} else {
					$opt[CURLOPT_POSTFIELDS] = http_build_query($parameters[0]);
				}
			} else {
				$opt[CURLOPT_POSTFIELDS] = $parameters[0];
			}
		}
		curl_setopt_array($ch, $opt);
		$out = curl_exec($ch);
		$info = curl_getinfo($ch);
		$err = curl_error($ch) and $out = "Error (".curl_errno($ch)."): ".$err;
		return [
			"content" => $out,
			"info"	  => $info
		];
	}
}