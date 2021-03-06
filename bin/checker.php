#!/usr/bin/env php
<?php

if ((!@include __DIR__.'/../../../autoload.php') && (!@include __DIR__.'/../vendor/autoload.php')) {
    die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL);
}

use rs\ContainerServiceChecker\Application\Application;

// run the command application
$application = new Application();
$application->run();