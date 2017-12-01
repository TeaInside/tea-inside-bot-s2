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
class AdminHammer extends CommandAbstraction implements EventContract
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
	 * Ban user.
	 *
	 */
	public function ban()
	{
		if ($this->hasRepliedMessage() && $this->isEnoughPrivileges()) {
			$kick = B::kickChatMember(
				[
					"chat_id" => $this->e['chat_id'],
					"user_id" => $this->e['reply_to']['from']['id']
				]
			);
			$bannedUser = "<a href=\"tg://user?id=".$this->e['reply_to']['from']['id']."\">" . htmlspecialchars($this->e['reply_to']['from']['fisrt_name'], ENT_QUOTES, 'UTF-8') . "</a>";
			$kick['info']['http_code'] === 200 and B::bg()::sendMessage(
				[
					"chat_id"    => $this->e['chat_id'],
					"text"	  	 => Lang::bind("{first_namelnik}") . " banned ". $bannedUser."!",
					"parse_mode" => "HTML"
				]
			);
		}

		return B::bg()::sendMessage(
			[
				"chat_id" 				=> $this->e['chat_id'],
				"text"    				=> Lang::get("help"),
				"reply_to_message_id"	=> $this->e['msg_id'],
				"parse_mode"			=> "HTML"
			]
		);
	}

	/**
	 * Check the message has replied message or not.
	 */
	private function hasRepliedMessage()
	{
		return isset($this->e['reply_to']);
	}

	/**
	 * Check the sender has enough privilege to ban user or not.
	 */
	private function isEnoughPrivileges()
	{
		if (in_array($this->e['user_id'], GLOBAL_ADMIN)) {
			return true;
		}
		$r = B::getChatAdministrators(["chat_id" => $this->e['chat_id']]);
		
	}
}
