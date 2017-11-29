<?php

use Utils\Hub\Singleton;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
final class DB
{
	use Singleton;

	/**
	 * PDO Instance
	 *
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * Constructor.
	 *
	 */
	public function __construct()
	{
		$this->pdo = new \PDO(
			"mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASS
		);
	}

	/**
	 *
	 * @param string $method
	 * @param array  $parameters
	 * @return mixed
	 */
	public static function __callStatic($method, $parameters)
	{
		return self::getInstance()->{$method}(...$parameters);
	}
}

/**
 * @param bool 	 $exe
 * @param object $st
 * @return void
 */
function pc($exe, $st)
{
	if (! $exe) {
		var_dump($st->errorInfo());
		exit(1);
	}
}