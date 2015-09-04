<?php
use LeoSlack\Application;
use Symfony\Component\HttpFoundation\Request;

require './vendor/autoload.php';

Application::create(require('./config.php'))->run(Request::createFromGlobals())->send();
