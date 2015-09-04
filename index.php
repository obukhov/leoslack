<?php
use Symfony\Component\HttpFoundation\Request;

require './vendor/autoload.php';
$config = require './config.php';


echo \LeoSlack\Application::create($config)->run(Request::createFromGlobals());
