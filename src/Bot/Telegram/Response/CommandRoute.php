<?php

namespace Bot\Telegram\Response;

use Telegram as B;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
trait CommandRoute
{
    private function buildRoute()
    {

        /*$a = B::getChatAdministrators(["chat_id" => -1001128970273]);
        var_dump(json_decode($a['content'], true));

        die;*/
        if (isset($this->e['text'])) {
            $s = explode(" ", $this->e['text'], 2);
            $s[0] = explode("@", $s[0]);
            $s[0] = $s[0][0];
        } else {
            $s[0] = "";
        }

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/start"||
                    $s[0] === "!start"||
                    $s[0] === "~start";
            },
            "Start@start"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/help"||
                    $s[0] === "!help"||
                    $s[0] === "~help";
            },
            "Help@help"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/sh"||
                    $s[0] === "!sh"||
                    $s[0] === "~sh"||
                    $s[0] === "shexec";
            },
            "Shell@bash"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/ban"||
                    $s[0] === "!ban"||
                    $s[0] === "~ban";
            },
            "AdminHammer@ban"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/welcome"||
                    $s[0] === "!welcome"||
                    $s[0] === "~welcome";
            },
            "Welcome@setWelcome"
        );
    }
}
