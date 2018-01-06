<?php

namespace Bot\LINE\Response;

use LINE;
USE Telegram;

trait CommandRoute
{
	private function invokeRoute()
	{
		$s  = strtolower($this->b['text']);
		$s0 = explode(" ", $s, 2);
		array_walk($s0, function (&$s) {
			$s = trim($s);
		});

		$this->set(
			function () use ($s) {
				return $s === "test";
			}, 
			function () {
				print LINE::bg()::push(
					[
						"to" => $this->b['chatId'],
						"messages" => [
							[
								"type" => "text",
								"text" => "Test Ok"
							]
						]
					]
				)['content'];
			}
		);

		$this->set(
			function () use ($s0) {
				if ($s0[0] === "jadwal" && count($s0) === 2) {
					$this->b['jadwalCmd'] = $s0[1];
					return true;
				}
			},
			"Jadwal@jadwal"
		);

		// SOLID Delivery
		$this->set(
			function () {
				return $this->b['chatId'] === "Ce20228a1f1f98e6cf9d6f6338603e962";
			},
			"Solid@solidDelivery"
		);
	}
}
