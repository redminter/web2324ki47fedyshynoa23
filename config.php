<?php

//config

require_once 'vendor/autoload.php';

$google_client = new Google_Client();

$google_client->setClientId('197728857219-kfiagi231jf27ki6qcmanbbtv7i4p7b9.apps.googleusercontent.com' );

$google_client->setClientSecret('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');

$google_client->setRedirectUri('https://business.minivns.me/index.php?page=login');

$google_client->addScope('email');

$google_client->addScope('profile');

session_start();

?>