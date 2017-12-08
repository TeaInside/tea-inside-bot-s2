<?php

namespace Bot\Telegram\Lang\Data;

use Bot\Telegram\Lang\Data\ID;
use Bot\Telegram\Abstraction\Language as LanguageAbstraction;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 */
class ID extends LanguageAbstraction
{
    public static $map = [
        "start" => ID\Start::class,
        "help"  => ID\Help::class,
        "sudo_reject" => ID\SudoReject::class
    ];
}
