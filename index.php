#!/usr/bin/env php
<?php

namespace Kiona;

require __DIR__ . '/vendor/autoload.php';

use Kiona\Console\Report;
use Symfony\Component\Console\Application;

$application = new Application();

$csvReportCommand = new Report();
$application->add($csvReportCommand);
$application->setDefaultCommand($csvReportCommand->getName());

$application->run();
