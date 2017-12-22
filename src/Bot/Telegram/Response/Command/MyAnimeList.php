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
        $str = explode(" ", $this->e['text'], 2);
        $str = isset($str[1]) ? strtolower($pure = trim($str[1])) : null;
        if (empty($str)) {
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
    }
}