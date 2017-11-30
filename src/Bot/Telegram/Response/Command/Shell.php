<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Shell extends CommandAbstraction implements EventContract
{

	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	private $e;

	/**
	 * Constructor.
	 *
	 * @param Bot\Telegram\Events\EventRecognition $event
	 */
	public function __construct(Event $event)
	{
		$this->e = $event;
	}

	/**
	 * "/start" command.
	 *
	 */
	public function bash()
	{
		$cmd = explode(" ", $this->e['text'], 2);
		$cmd[1] = empty($cmd[1]) ? "" : $cmd[1];
		if ($this->isSecure($cmd[1])) {
			$handle = fopen(
				$file = "/tmp/" . substr(
					sha1($cmd[1] . time()), 0, 5
				) . substr(
					sha1(microtime(true)), 0, 5
				) . ".sh", 
				"w"
			);
			flock($handle, LOCK_EX);
			fwrite($handle, $cmd[1]);
			fclose($handle);
			$stdout = shell_exec("sudo chmod +x ".$file);
			$stdout = shell_exec($file." 2>&1");
			if ($stdout == "") {
				$stdout = "~";
			}
			unlink($file);
			$stdout = "<pre>".htmlspecialchars($stdout, ENT_QUOTES, 'UTF-8')."</pre>";
		} else {
			$stdout = Lang::get("sudo_reject");
		}


		return B::bg()::sendMessage(
			[
				"chat_id" 				=> $this->e['chat_id'],
				"text"    				=> $stdout,
				"reply_to_message_id"	=> $this->e['msg_id'],
				"parse_mode"			=> "HTML"
			]
		);
	}

	/**
	 *
	 * @param string $cmd
	 */
	private function isSecure($cmd)
	{
		if (in_array($this->e['user_id'], SUDOERS)) {
			return true;
		}
		if (
			strpos($cmd, "sudo ") !== false || 
			(strpos($cmd, "rm") !== false && strpos($cmd, "-")!==false)
		) {
			return false;
		}
		return true;
	}
}