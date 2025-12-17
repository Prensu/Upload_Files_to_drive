<?php
// Include configuration file
require_once 'config.php';

// Create database connection (WITH PORT)
$db = new mysqli(
    DB_HOST,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME,
    DB_PORT
);

// Check connection
if ($db->connect_error) {
    $safeUser = defined('DB_USERNAME') ? DB_USERNAME : '';
    $safeHost = defined('DB_HOST') ? DB_HOST : '';
    $safeDb   = defined('DB_NAME') ? DB_NAME : '';
    $safePort = defined('DB_PORT') ? DB_PORT : '';

    die(
        "Connection failed: {$db->connect_error}\n" .
        "Check database credentials in config.php.\n" .
        "Current: user='{$safeUser}', host='{$safeHost}', port='{$safePort}', db='{$safeDb}'."
    );
}
