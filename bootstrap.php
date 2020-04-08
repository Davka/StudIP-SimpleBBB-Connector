<?php
require_once __DIR__ . '/vendor/autoload.php';
StudipAutoloader::addAutoloadPath(__DIR__ . '/classes');
StudipAutoloader::addAutoloadPath(__DIR__ . '/classes', 'Vec\\BBB');
StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
StudipAutoloader::addAutoloadPath(__DIR__ . '/models', 'Vec\\BBB');