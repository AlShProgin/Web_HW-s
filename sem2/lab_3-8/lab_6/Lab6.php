<?php
require __DIR__ . "/vendor/autoload.php";

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . "/templates");
$twig = new Environment($loader);
$testMessage = "Checking if test twig works";
echo $twig->render('lab6_result.twig', ['message' => $testMessage]);

$logger = new Logger('my_logger');
$logger->pushHandler(new StreamHandler(__DIR__.'/bin/logs/lab6.log', Logger::DEBUG));
$logger->info('Monolog connected');
