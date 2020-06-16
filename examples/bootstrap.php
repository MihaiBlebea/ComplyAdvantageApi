<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Chip\ComplyAdvantageApi\ComplyAdvantageApi;

$client = new ComplyAdvantageApi(getenv('API_KEY'));