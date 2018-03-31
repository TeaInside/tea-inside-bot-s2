<?php

namespace Bot\Telegram\Lang\Data\ID;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Help
{
    public static $text =
    "<b>Berikut ini adalah daftar menu bot:</b>

<b>SuperUser:</b>
/sh <i>[bash script]</i>  <code>Menjalankan perintah pada shell.</code>
/sudoers_list  <code>Menampilkan daftar user sudoers</code>

<b>Group Admin & SuperUser:</b>
/warn <i>[id|username|text_mention|null] [reason]</i>  <code>Memberikan peringatan pada user.</code>
/kick <i>[id|username|text_mention|null] [reason]</i>  <code>Kick user.</code>
/mute <i>[id|username|text_mention|null] [reason]</i>  <code>Mute user.</code>
/ban <i>[id|username|text_mention|null] [reason]</i>  <code>Ban user.</code>
/unban <i>[id|username|text_mention|null] [reason]</i>  <code>Unban user.</code>
/unmute <i>[id|username|text_mention|null] [reason]</i>  <code>Unmute user.</code>

<b>Public:</b>
/help  <code>Menampilkan menu ini.</code>
/whatanime <code>Pencarian anime dengan screenshoot.</code>
/anime <i>[judul_anime]</i>  <code>Mencari anime (MyAnimeList).</code>
/manga <i>[judul_manga]</i>  <code>Mencari manga (MyAnimeList).</code>
/idan <i>[id_anime]</i>  <code>Info anime (MyAnimeList).</code>
/idma <i>[id_manga]</i>  <code>Info manga (MyAnimeList).</code>
/admin  <code>Tampilkan daftar admin.</code>
/report <i>[message]</i>  <code>Laporkan sesuatu ke admin.</code>
/tl <i>[from] [to] [text]</i>  <code>Translate (GoogleTranslate).</code>
/tlr <i>[from] [to]</i>  <code>Translate pesan terbalas.</code>
/ping  <code>Cek ping bot.</code>
/phost <i>[domain|ip_address]</i>  <code>Ping domain/ip.</code>
/s/<i>[regexp]</i>/<i>[replace]</i>  <code>Message correction.</code>

Laporkan bug dan error ke @TeaInside";
}

