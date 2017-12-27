<?php

namespace Bot\Telegram\Events;

use ArrayAccess;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class EventRecognition implements ArrayAccess
{
    /**
     *
     * @var array
     */
    private $container = [];

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
        $this['msg_type'] = "";
        $this['update_id'] = i($input['update_id']);
        if (isset($input['message'])) {
            $this['msg_id']     = $input['message']['message_id'];
            $this['first_name'] = $input['message']['from']['first_name'];
            $this['last_name']  = i($input['message']['from']['last_name']);
            $this['name']       = $this['first_name'] . ($this['last_name'] !== null ? " ".$this['last_name'] : "");
            $this['username']   = i($input['message']['from']['username']);
            $this['is_bot']         = i($input['message']['from']['is_bot']);
            $this['user_id']    = $input['message']['from']['id'];
            $this['chat_id']    = $input['message']['chat']['id'];
            $this['chattype']   = $input['message']['chat']['type'];
            $this['chattitle']  = i($input['message']['chat']['title'], $this['name']);
            $this['chatuname']  = i($input['message']['chat']['username']);
            $this['date']       = $input['message']['date'];
            $this['reply_to']   = i($input['message']['reply_to_message']);
            if (isset($input['message']['text'])) {
                $this['msg_type'] = "text";
                $this['text']     = $input['message']['text'];
            } elseif (isset($input['message']['new_chat_members'])) {
                $this['msg_type'] = "new_chat_members";
                $this['new_chat_members'] = $input['message']['new_chat_members'];
            } elseif (isset($input['message']['photo'])) {
                $this['text'] = $this['caption'] = i($input['message']['caption']);
                $this['msg_type'] = "photo";
            } elseif (isset($input['message']['sticker'])) {
                $this['sticker']  = $input['message']['sticker'];
                $this['emoji']    = $input['message']['sticker']['emoji'];
                $this['msg_type'] = "sticker";
            }
        }
    }

    /**
     * @param string $offset
     * @param any    $value
     */
    public function offsetSet($offset, $value)
    {
        $this->container[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : false;
    }
}

function i(&$variable, $default = null)
{
    return isset($variable) ? $variable : $default;
}
