<?php
require "config/telegram/main.php";
require "vendor/autoload.php";

$a = '{"data":{"from":1077.33,"to":1078.58,"i":0,"start":1061.33,"end":1082.58,"t":1078.08,"season":"2014-07","anime":"PSYCHO-PASS \u65b0\u7de8\u96c6\u7248","file":"[KTXP][PSYCHO-PASS Extended Edition][02][BIG5][720p][MP4].mp4","episode":2,"expires":1514378289,"token":"sb2EYw2FCOegH-DBSoSSww","tokenthumb":"ntMV7oF7gHiMi7t7zwXUfw","diff":9.423394,"title":"PSYCHO-PASS \u30b5\u30a4\u30b3\u30d1\u30b9 \u65b0\u7de8\u96c6\u7248","title_english":"Psycho-Pass Shin Henshuu-ban","title_romaji":"Psycho-Pass Shin Henshuu-ban"},"video_url":"https:\/\/webhook.teainside.ga\/storage\/telegram\/whatanime_cache\/video\/edf2a837982624b35aaee3959e5e564d3cf9e213.mp4"}';
$a = json_decode($a, true);

