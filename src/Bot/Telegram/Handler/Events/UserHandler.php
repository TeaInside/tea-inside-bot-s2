<?php

namespace Bot\Telegram\Handler\Events;

use Bot\Telegram\Models\User;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;

class UserHandler implements EventContract
{

	/**
	 * @var \Bot\Telegram\Events\EventRecognition
	 */
	private $e;

	/**
     * Constructor.
     *
     * @param \Bot\Telegram\Events\EventRecognition $event
     */
    public function __construct(Event $event)
    {
    	$this->e = $event;
    }

    public function run()
    {
        $this->handle();
        $class = '\Bot\Telegram\Handler\Events\PrivateMessage';
        switch ($this->e['msg_type']) {
            case 'text':
                    $class .= '\Text';
                break;
            
            default:
                break;
        }

        $q = new $class($this->e);
        $q->run();
    }

	public function handle()
	{
		if ($currentInfo = User::getInfo($this->e['user_id'])) {

    	} else {
    		User::insert(
    			[
    				"user_id" 	=> $this->e['user_id'],
    				"username"	=> $this->e['username'],
    				"first_name"=> $this->e['first_name'],
    				"last_name"	=> $this->e['last_name'],
    				"display_name"=> $this->e['name'],
    				"photo"	=> null,
    				"authority"	=> 'user',
    				"is_bot"	=> (int) $this->e['is_bot'],
    				"created_at"=> date('Y-m-d H:i:s')
    			]
    		);
    	}
	}
}