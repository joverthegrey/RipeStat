<?php

require "../vendor/autoload.php";
use RipeStat\AbuseContactFinder;

$rs =  new AbuseContactFinder();

$data = $rs->get('145.58.29.114'); //nos.nl (dutch public news broadcaster)

print_r($data);
