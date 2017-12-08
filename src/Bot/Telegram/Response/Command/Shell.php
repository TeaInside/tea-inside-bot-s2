<?php

namespace Bot\Telegram\Response\Command;

use Telegram as B;
use Bot\Telegram\Lang;
use Bot\Telegram\Contracts\EventContract;
use Bot\Telegram\Events\EventRecognition as Event;
use Bot\Telegram\Abstraction\Command as CommandAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class Shell extends CommandAbstraction implements EventContract
{

    /**
     * @var \Bot\Telegram\Events\EventRecognition
     */
    private $e;

    /**
     * Constructor.
     *
     * @param Bot\Telegram\Events\EventRecognition $event
     */
    public function __construct(Event $event)
    {
        $this->e = $event;
    }

    /**
     * Bash.
     *
     */
    public function bash()
    {
        $cmd = explode(" ", $this->e['text'], 2);
        $cmd[1] = empty($cmd[1]) ? "" : $cmd[1];
        if ($status = $this->isSecure($cmd[1])) {
            $handle = fopen(
                $file = "/tmp/" . substr(
                    sha1($cmd[1] . time()),
                    0,
                    5
                ) . substr(
                    sha1(microtime(true)),
                    0,
                    5
                ) . ".sh",
                "w"
            );
            flock($handle, LOCK_EX);
            fwrite($handle, $cmd[1]);
            fclose($handle);
            $stdout = shell_exec("sudo chmod +x ".$file);
            if ($status === "sudoer") {
                $stdout = shell_exec($file." 2>&1");
            } else {
                if (strpos(shell_exec("sudo -u limited whoami 2>&1"), "unknown user:") !== false) {
                    $handle = fopen("/tmp/limited_passwd", "w");
                    flock($handle, LOCK_EX);
                    fwrite($handle, "123\n123");
                    fclose($handle);
                    shell_exec("sudo adduser limited < /tmp/limited_passwd");
                    unlink("/tmp/limited_passwd");
                }
                $stdout = shell_exec("sudo -u limited " . $file . " 2>&1");
            }
            if ($stdout == "") {
                $stdout = "~";
            }
            unlink($file);
            $stdout = "<pre>".htmlspecialchars($stdout, ENT_QUOTES, 'UTF-8')."</pre>";
        } else {
            $this->reportIncidentToSudoers();
            $stdout = Lang::get("sudo_reject");
        }


        return B::bg()::sendMessage(
            [
                "chat_id"               => $this->e['chat_id'],
                "text"                  => $stdout,
                "reply_to_message_id"   => $this->e['msg_id'],
                "parse_mode"            => "HTML"
            ]
        );
    }

    /**
     *
     * @param string $cmd
     */
    private function isSecure($cmd)
    {
        if (in_array($this->e['user_id'], SUDOERS)) {
            return "sudoer";
        }
        if (strpos($cmd, "sudo ") !== false ||
            (strpos($cmd, "rm") !== false && strpos($cmd, "-")!==false)
        ) {
            return false;
        }
        return "user";
    }

    /**
     * Report incident to sudoers.
     */
    private function reportIncidentToSudoers()
    {
        $incidentMessage = "<b>WARNING</b>
<b>Unwanted user tried to use sudo.</b>

<b>• Rejected at:</b> ".date("Y-m-d H:i:s")."
<b>• Tried by:</b> " . Lang::bind("{namelink}") . " (<code>" . $this->e['user_id'] . "</code>)
<b>• Chat Room:</b> " . $this->e['chattype'] . " (" . Lang::bind("{chat_link}") . ")
<b>• Message ID:</b> " . $this->e['msg_id'] . "
<b>• Command:</b> <code>" . htmlspecialchars($this->e['text']) . "</code>" . ($this->e['chatuname'] ? ("\n<b>•</b> <a href=\"https://t.me/" . $this->e['chatuname'] . "/" . $this->e['msg_id'] ."\">Go to the message</a>") : "");

        foreach (SUDOERS as $val) {
            B::bg()::forwardMessage(
                [
                    "chat_id" => $val,
                    "from_chat_id" => $this->e['chat_id'],
                    "message_id" => $this->e['msg_id']
                ]
            );
            B::bg()::sendMessage(
                [
                    "chat_id"    => $val,
                    "text"       => $incidentMessage,
                    "parse_mode" => "HTML",
                    "disable_web_page_preview" => true
                ]
            );
        }
    }
}
