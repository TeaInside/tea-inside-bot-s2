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
                    isset($this->e['text']) && 
                    (
                        strpos(strtolower($this->e['text']), "/debug") !== false ||
                        strpos(strtolower($this->e['text']), "~debug") !== false ||
                        strpos(strtolower($this->e['text']), "!debug") !== false
                    );
            },
            function () {
                $a = B::bg()::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text" => "<code>".htmlspecialchars(json_encode($this->e->input, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8')."</code>",
                        "parse_mode" => "HTML",
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                )['content'];
                return true;
            }
        );

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
                    $s[0] === "/kick"||
                    $s[0] === "!kick"||
                    $s[0] === "~kick";
            },
            "AdminHammer@kick"
        );

        $this->set(
            function () use ($s) {
                 return
                    $s[0] === "/pin"||
                    $s[0] === "!pin"||
                    $s[0] === "~pin";
            },
            "AdminHammer@pin"
        );

        $this->set(
            function () use ($s) {
                 return
                    $s[0] === "/promote"||
                    $s[0] === "!promote"||
                    $s[0] === "~promote";
            },
            "AdminHammer@promote"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/anime"||
                    $s[0] === "!anime"||
                    $s[0] === "~anime"||
                    (
                        isset($this->e['reply_to']['text']) and $this->e['reply_to']['text'] === "Anime apa yang ingin dicari?" and $this->e['anime_list_title'] = $this->e['text']
                    );
            },
            "MyAnimeList@animeSearch"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/manga"||
                    $s[0] === "!manga"||
                    $s[0] === "~manga"||
                    (
                        isset($this->e['reply_to']['text']) and $this->e['reply_to']['text'] === "Manga apa yang ingin dicari?" and $this->e['anime_list_title'] = $this->e['text']
                    );
            },
            "MyAnimeList@mangaSearch"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/idan"||
                    $s[0] === "!idan"||
                    $s[0] === "~idan"||
                    (
                        isset($this->e['reply_to']['text']) and $this->e['reply_to']['text'] === "Balas dengan ID anime!" and $this->e['anime_list_id'] = $this->e['text']
                    );
            },
            "MyAnimeList@animeInfo"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/idma"||
                    $s[0] === "!idma"||
                    $s[0] === "~idma"||
                    (
                        isset($this->e['reply_to']['text']) and $this->e['reply_to']['text'] === "Balas dengan ID manga!" and $this->e['anime_list_id'] = $this->e['text']
                    );
            },
            "MyAnimeList@mangaInfo"
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
        
        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/tl"||
                    $s[0] === "!tl"||
                    $s[0] === "~tl"||
                    $s[0] === "/tr"||
                    $s[0] === "!tr"||
                    $s[0] === "tr";
            },
            "GoogleTranslate@translate"
        );

        $this->set(
            function () use ($s) {
                return
                    $s[0] === "/tlr"||
                    $s[0] === "!tlr"||
                    $s[0] === "~tlr"||
                    $s[0] === "tlr";
            },
            "GoogleTranslate@translateToRepliedMessage"
        );

        $this->set(
            function () use ($s) {
                return substr($s[0], 0, 5) === "<?php";
            },
            "Virtualizor@php"
        );

        $this->set(
            function () use ($s) {
                return 
                    substr($s[0], 0, 3) === "<?js"||
                    substr($s[0], 0, 6) === "<?node";
            },
            "Virtualizor@js"
        );
        
        $this->set(
            function () use ($s) {
                return 
                    substr($s[0], 0, 3) === "<?py";
            },
            "Virtualizor@python"
        );

        $this->set(
            function () use ($s) {
                return substr($s[0], 0, 3) === "<?c";
            },
            "Virtualizor@c"
        );

        $this->set(
            function () use ($s) {
                return 
                    ($s[0]=substr($s[0], 0, 5)) === "<?c++"||
                    $s[0] === "<?cpp";
            },
            "Virtualizor@cpp"
        );
    }
}