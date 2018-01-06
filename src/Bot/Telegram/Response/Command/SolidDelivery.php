<?php

namespace Bot\Telegram\Response\Command;

use LINE;
use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class SolidDelivery extends CommandAbstraction implements EventContract
{
    public function run()
    {
        if ($this->e['msg_type'] === "text") {
            $data = [
                "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                "messages" => LINE::buildLongTextMessage("{$this->e['name']}\n\n{$this->e['text']}")
            ];
        } elseif ($this->e['msg_type'] === "photo") {
            $data[] = [
                "type" => "image",
                "originalContentUrl" => $url,
                "previewImageUrl" => $url
            ];
            if (! empty($this->e['text'])) {
                $data[] = [
                    "type" => "text",
                    "text" => "{$this->e['name']}\n\n{$this->e['text']}"
                ];
            }
            $data = [
                "to" => "Ce20228a1f1f98e6cf9d6f6338603e962",
                "messages" => $data
            ];
        }
        LINE::bg()::push($data);
    }

    private function savePhoto()
    {
        $p = end($this->e['photo']);
        $a = json_decode(B::getFile([
            "file_id" => $p['file_id']
        ])['content'], true);
        $st = new Curl("https://api.telegram.org/file/bot".TOKEN."/".$a['result']['file_path']);
        if (file_put_contents(data."/tmp/".($t = sha1($p['file_id'])).".jpg", $st->exec())) {
            return STORAGE_URL."/tmp/{$t}.jpg";
        } else {
            return false;
        }
    }
}
