<?php
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

$username = '';
$password = '';

$client = new \pmill\MFP\Client();
$client->setCredentials($username, $password);
$currentWeight = $client->getCurrentWeight();

var_dump($currentWeight);
