<?php

namespace Bot\LINE;

use Bot\LINE\Response;

class Bot
{
	/**
	 * @var array
	 */
	private $input = [];

	/**
	 * @var array
	 */
	public $e = [];

	/**
	 * Constructor.
	 *
	 * @param array $input
	 */
	public function __construct($input)
	{
		$this->input = $input;
		file_put_contents(LINE_LOG_DIR."/input.last", json_encode($this->input, 128));
	}

	public function buildEvent()
	{
		if (isset($this->input['events'])) {
			foreach ($this->input['events'] as $k => $v) {
				$this->e[] = $this->eventIdentication($v);
			}
		}
	}

	private function eventIdentication($e)
	{
		$r = [];
		if ($e['type'] === "message") {
			if (isset($e['source']['groupId'])) {
				$r['chatType'] = 'group';
				$r['chatId'] = $e['source']['groupId'];
			} else {
				$r['chatType'] = 'private';
				$r['userId'] = $r['chatId'] = $e['source']['userId'];
			}
			$r['replyToken'] = $e['replyToken'];
			$r['timestamp'] = $e['timestamp'];
			if ($e['message']['type'] === "text") {
				$r['msgType'] = "text";
				$r['text']	  = $e['message']['text'];
				$r['msgId']   = $e['message']['id'];
			} elseif ($e['message']['type'] === "image") {
				$r['msgType'] = "image";
				$r['msgId']   = $e['message']['id'];
			}
		}
		return $r;
	}

	public function run()
	{
		$st = new Response($this);
		$st->run();
		return true;
	}
}