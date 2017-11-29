<?php

namespace Bot\Telegram\Response;

use Closure;
use Bot\Telegram\Response\CommandRoute;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Contracts\Response as ResponseContract;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Command implements EventContract, ResponseContract
{
	use CommandRoute;

	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	private $e;

	/**
	 * @var array
	 */
	private $rotues = [];

	/**
	 * Constructor.
	 *
	 * @param \Bot\Telegram\Events\EventRecognition $event
	 */
	public function __construct(Event $event)
	{
		$this->e = $event;
	}

	/**
	 * Response action
	 */
	public function action()
	{
		$this->buildRoute();
		$this->parseRoutes();
	}

	/**
	 * Set command route.
	 *
	 */
	final private function set(Closure $condition, $action)
	{
		$this->routes[] = [$condition, $action];
	}

	/**
	 * Parse command routes.
	 *
	 */
	private function parseRoutes()
	{
		foreach ($this->routes as $val) {
			if ($val[0]()) {
				if (! $val[1] instanceof Closure) {
					$v = explode("@", $val[1]);
					$v[0] = "\\Bot\\Telegram\\Response\\Command\\" . $v[0];
					$val[1] = new $v[0]($this->e);
					$this->checkInstance($val[1]);
					$rt = $val[1]->{$v[1]}();
				} else {
					$rt = $val[1]();
				}
				if ($rt) {
					break;
				}
			}
		}
	}

	/**
	 * @param object $instance
	 */
	private function checkInstance($instance)
	{
		return 
			$instance instanceof CommandAbstraction 
				and
					in_array(EventContract::class, class_implements($instance));
	}
}
