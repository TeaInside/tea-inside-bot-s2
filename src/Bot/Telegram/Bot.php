<?php

namespace Bot\Telegram;

use Bot\Telegram\Response;
use Bot\Telegram\Handler\EventHandler;
use Bot\Telegram\Events\EventRecognition;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
final class Bot
{

    /**
     * @var array
     */
    public $input = [];

    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Build current event.
     */
    public function buildEvent()
    {
        $this->input = new EventRecognition($this->input);
    }

    /**
     *
     * @return bool
     */
    public function run()
    {
        $app = new Response($this->input);
        $app->action();
        $app = new EventHandler($this->input);
        return $app->run();
    }
}
