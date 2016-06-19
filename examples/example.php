<?php
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

$username = '';
$password = '';

$client = new \pmill\MFP\Client();
$client->setCredentials($username, $password);
$currentWeight = $client->getCurrentWeight();

echo sprintf(
    "Your current weight is %f %s",
    $currentWeight['value'],
    $currentWeight['unit']).PHP_EOL;

$lastWeeksWeight = $client->getHistoricalWeight(\pmill\MFP\ReportTimespan::WEEK);

foreach ($lastWeeksWeight as $weight) {
    echo sprintf(
            "%s %f pounds",
            $weight['date'],
            $weight['total']).PHP_EOL;
}