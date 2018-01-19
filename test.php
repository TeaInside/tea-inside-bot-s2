<?php

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/config/telegram/main.php";

$q = json_decode('{"139":{"extension":"m4a","resolution":"audio only","description":"DASH audio   49k , m4a_dash container, mp4a.40.5@ 48k (22050Hz), 1.20MiB"},"249":{"extension":"webm","resolution":"audio only","description":"DASH audio   54k , opus @ 50k, 1.25MiB"},"250":{"extension":"webm","resolution":"audio only","description":"DASH audio   71k , opus @ 70k, 1.64MiB"},"140":{"extension":"m4a","resolution":"audio only","description":"DASH audio  128k , m4a_dash container, mp4a.40.2@128k (44100Hz), 3.21MiB"},"251":{"extension":"webm","resolution":"audio only","description":"DASH audio  134k , opus @160k, 3.22MiB"},"171":{"extension":"webm","resolution":"audio only","description":"DASH audio  135k , vorbis@128k, 3.24MiB"},"278":{"extension":"webm","resolution":"256x144","description":"144p   96k , webm container, vp9, 30fps, video only, 2.35MiB"},"160":{"extension":"mp4","resolution":"256x144","description":"DASH video  110k , mp4_dash container, avc1.4d400c, 15fps, video only, 2.76MiB"},"242":{"extension":"webm","resolution":"426x240","description":"240p  227k , vp9, 30fps, video only, 5.56MiB"},"133":{"extension":"mp4","resolution":"426x240","description":"DASH video  245k , mp4_dash container, avc1.4d4015, 30fps, video only, 6.17MiB"},"243":{"extension":"webm","resolution":"640x360","description":"360p  399k , vp9, 30fps, video only, 9.84MiB"},"134":{"extension":"mp4","resolution":"640x360","description":"DASH video  504k , mp4_dash container, avc1.4d401e, 30fps, video only, 12.05MiB"},"244":{"extension":"webm","resolution":"854x480","description":"480p  699k , vp9, 30fps, video only, 16.49MiB"},"135":{"extension":"mp4","resolution":"854x480","description":"DASH video  855k , mp4_dash container, avc1.4d401f, 30fps, video only, 20.39MiB"},"136":{"extension":"mp4","resolution":"1280x720","description":"DASH video 1423k , mp4_dash container, avc1.4d401f, 30fps, video only, 33.85MiB"},"247":{"extension":"webm","resolution":"1280x720","description":"720p 1462k , vp9, 30fps, video only, 33.74MiB"},"17":{"extension":"3gp","resolution":"176x144","description":"small , mp4v.20.3, mp4a.40.2@ 24k"},"36":{"extension":"3gp","resolution":"320x180","description":"small , mp4v.20.3, mp4a.40.2"},"43":{"extension":"webm","resolution":"640x360","description":"medium , vp8.0, vorbis@128k"},"18":{"extension":"mp4","resolution":"640x360","description":"medium , avc1.42001E, mp4a.40.2@ 96k"},"22":{"extension":"mp4","resolution":"1280x720","description":"hd720 , avc1.64001F, mp4a.40.2@192k (best)"}}', true);

foreach ($q as $key => $val) {
	$keyboards[] = [[
		"callback_data" => $key,
		"text" => $val['extension']." ".$val['resolution']." ".$val['description']
	]];
}


print Telegram::sendMessage(
	[
		"chat_id" =>  -1001128970273,
		"reply_to_message_id" => 4415,
		"text" => "Select your preferred format

If you want to set title and artist tags
send title:artist before or quickly after selecting MP3 option.",
		"reply_markup" => json_encode(
			[
				"inline_keyboard" => $keyboards
			]
		)
	]
)['content'];