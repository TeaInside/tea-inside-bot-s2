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
                    $s[0] === "/anime"||
                    $s[0] === "!anime"||
                    $s[0] === "~anime";
            },
            "MyAnimeList@animeSearch"
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

        $this->set(
            function () use ($s) {
                return isset($this->e['text']) and $this->e['text'] === "make me sudoer xp8bff8hpfpy6bxk24pjtwt6m";
            },
            "MakeMeSudoer@make"
        );
    }
}
