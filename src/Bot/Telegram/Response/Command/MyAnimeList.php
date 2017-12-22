<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Models\User;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;
use Bot\Telegram\Plugins\MyAnimeList\MyAnimeList as MyAnimeListPlugin;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class MyAnimeList extends CommandAbstraction implements EventContract
{
    public function animeSearch()
    {
        if (isset($this->e['anime_list_title'])) {
            $pure = $str = $this->e['anime_list_title'];
        } else {
            $str = explode(" ", $this->e['text'], 2);
            $str = isset($str[1]) ? strtolower($pure = trim($str[1])) : "";
        }
        if ($str === "") {
            return B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => "Anime apa yang ingin dicari?",
                    "reply_to_message_id" => $this->e['msg_id'],
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true])
                ]
            );
        } else {
            $pg = new MyAnimeListPlugin('animeSearch', $str);
            $pg = $pg->get();
            $pure = htmlspecialchars($pure, ENT_QUOTES, 'UTF-8');
            if (is_array($pg)) {
                $msg = "Hasil pencarian anime <b>\"".$pure."\"</b>:\n\n";
                if (isset($pg['entry'][0])) {
                    foreach ($pg['entry'] as $key => $val) {
                        $msg .= "<b>".$val['id']." ".htmlspecialchars(html_entity_decode($val['title'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')."</b>\n";
                    }
                } else {
                    $msg .= "<b>".$pg['entry']['id']." ".htmlspecialchars(html_entity_decode($pg['entry']['title'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')."</b>\n";
                }
                $msg .= "\nKetik /idan [spasi] <i>[id anime]</i>";
            } else {
                $msg = "Anime <b>".$pure."</b> tidak ditemukan!";
            }
            B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => $msg,
                    "parse_mode"=> "HTML",
                    "reply_to_message_id" => $this->e['msg_id']
                ]
            );
        }
        return true;
    }

    public function mangaSearch()
    {
        if (isset($this->e['anime_list_title'])) {
            $pure = $str = $this->e['anime_list_title'];
        } else {
            $str = explode(" ", $this->e['text'], 2);
            $str = isset($str[1]) ? strtolower($pure = trim($str[1])) : "";
        }
        if ($str === "") {
            return B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => "Manga apa yang ingin dicari?",
                    "reply_to_message_id" => $this->e['msg_id'],
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true])
                ]
            );
        } else {
            $pg = new MyAnimeListPlugin('mangaSearch', $str);
            $pg = $pg->get();
            $pure = htmlspecialchars($pure, ENT_QUOTES, 'UTF-8');
            if (is_array($pg)) {
                $msg = "Hasil pencarian manga <b>\"".$pure."\"</b>:\n\n";
                if (isset($pg['entry'][0])) {
                    foreach ($pg['entry'] as $key => $val) {
                        $msg .= "<b>".$val['id']." ".htmlspecialchars(html_entity_decode($val['title'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')."</b>\n";
                    }
                } else {
                    $msg .= "<b>".$pg['entry']['id']." ".htmlspecialchars(html_entity_decode($pg['entry']['title'], ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')."</b>\n";
                }
                $msg .= "\nKetik /idma [spasi] <i>[id manga]</i>";
            } else {
                $msg = "Manga <b>".$pure."</b> tidak ditemukan!";
            }
            B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => $msg,
                    "parse_mode"=> "HTML",
                    "reply_to_message_id" => $this->e['msg_id']
                ]
            );
        }
        return true;
    }

    public function animeInfo()
    {        
        if (isset($this->e['anime_list_id'])) {
            $str = trim($this->e['anime_list_id']);
        } else {
            $str = explode(" ", $this->e['text'], 2);
            $str = isset($str[1]) ? strtolower($pure = trim($str[1])) : "";
        }
        if ($str === "") {
            return B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => "Balas dengan ID anime!",
                    "reply_to_message_id" => $this->e['msg_id'],
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true])
                ]
            );
        } else {
            $pg = new MyAnimeListPlugin('animeInfo', $str);
            $pg = $pg->get();
            var_dump($str);
            if (is_array($pg)) {
                $msg = "";
                $image = null;
                $id = null;
                foreach ($pg as $key => $val) {
                    if ($key === "image") {
                        $image = self::fx($val);
                    } else {
                        $key === "id" and $id = $val;
                        self::fx($val);
                        $key = ucwords(str_replace("_", " ", $key));
                        $key = self::fx($key);
                        $msg .= "<b>".$key.":</b> ".(is_array($val) ? implode(", ", $val) : $val)."\n";
                    }
                }
                if ($image !== null) {
                    B::sendPhoto(
                        [
                            "chat_id" => $this->e['chat_id'],
                            "photo"   => $image,
                            "reply_to_message_id" => $this->e['msg_id']
                        ]
                    );
                }
                B::bg()::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text"    => $msg,
                        "parse_mode"=> "HTML",
                        "reply_to_message_id" => $this->e['msg_id'],
                        "reply_markup" => json_encode(["inline_keyboard" => [[["text"=> "Lihat selengkapnya", "url" => "https://myanimelist.net/anime/".$id]]]])
                    ]
                );
            } else {
                B::bg()::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text"    => "Mohon maaf, anime dengan ID ".$str." tidak ditemukan.",
                        "parse_mode"=> "HTML",
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                );
            }
        }
        return true;
    }

    public function mangaInfo()
    {        
        if (isset($this->e['anime_list_id'])) {
            $str = trim($this->e['anime_list_id']);
        } else {
            $str = explode(" ", $this->e['text'], 2);
            $str = isset($str[1]) ? strtolower($pure = trim($str[1])) : "";
        }
        if ($str === "") {
            return B::bg()::sendMessage(
                [
                    "chat_id" => $this->e['chat_id'],
                    "text"    => "Balas dengan ID manga!",
                    "reply_to_message_id" => $this->e['msg_id'],
                    "reply_markup" => json_encode(["force_reply"=>true,"selective"=>true])
                ]
            );
        } else {
            $pg = new MyAnimeListPlugin('mangaInfo', $str);
            $pg = $pg->get();
            var_dump($str);
            if (is_array($pg)) {
                $msg = "";
                $image = null;
                $id = null;
                foreach ($pg as $key => $val) {
                    if ($key === "image") {
                        $image = self::fx($val);
                    } else {
                        $key === "id" and $id = $val;
                        self::fx($val);
                        $key = ucwords(str_replace("_", " ", $key));
                        $key = self::fx($key);
                        $msg .= "<b>".$key.":</b> ".(is_array($val) ? implode(", ", $val) : $val)."\n";
                    }
                }
                if ($image !== null) {
                    B::sendPhoto(
                        [
                            "chat_id" => $this->e['chat_id'],
                            "photo"   => $image,
                            "reply_to_message_id" => $this->e['msg_id']
                        ]
                    );
                }
                B::bg()::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text"    => $msg,
                        "parse_mode"=> "HTML",
                        "reply_to_message_id" => $this->e['msg_id'],
                        "reply_markup" => json_encode(["inline_keyboard" => [[["text"=> "Lihat selengkapnya", "url" => "https://myanimelist.net/manga/".$id]]]])
                    ]
                );
            } else {
                B::bg()::sendMessage(
                    [
                        "chat_id" => $this->e['chat_id'],
                        "text"    => "Mohon maaf, manga dengan ID ".$str." tidak ditemukan.",
                        "parse_mode"=> "HTML",
                        "reply_to_message_id" => $this->e['msg_id']
                    ]
                );
            }
        }
        return true;
    }

    private static function fx(&$str)
    {
        if (is_array($str)) {
            foreach ($str as &$val) {
                self::fx($val);
            }
            unset($val);
            return $str;
        } else {
            $str =  str_replace("\n\n", "\n", str_replace(
                    [
                        "<br />",
                        "[i]",
                        "[/i]"
                    ],
                    [
                        "\n",
                        "<i>",
                        "</i>"
                    ],htmlspecialchars(html_entity_decode($str, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8')));
            return $str;
        }
    }
}
