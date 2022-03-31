#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Cart\ShoppingCart;

$application = new Application('Shopping Cart');

$calculate = new ShoppingCart();

$application->add($calculate);

$application->setDefaultCommand($calculate->getName(), true);


$application->run();