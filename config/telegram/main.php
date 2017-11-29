<?php
/**
 * Telegram main configuration.
 */


define("BASEPATH", realpath(__DIR__ . "/../.."));
define("LOG_DIR", BASEPATH."/logs/telegram");

/**
 * MySQL Database
 */
define("DB_HOST", "localhost");
define("DB_PORT", "3306");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "database_name");

/**
 * Sudoers and global admin.
 */
define("SUDOERS", []);
define("GLOBAL_ADMINS", array_merge(SUDOERS, []));

/**
 * Bot token.
 */
define("TOKEN", "");
