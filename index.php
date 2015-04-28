<?php
/** ---------------------------------------------------------------- **/
// This is the core app.
/** ---------------------------------------------------------------- **/
if (!file_exists('bootstrap.php')) {
    throw new \Exception('Where is the bootstrap.php?');
}

require_once 'bootstrap.php';
