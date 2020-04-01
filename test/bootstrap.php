<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

date_default_timezone_set('UTC');
error_reporting(E_ALL); // ensures that notices can be caught by tests
