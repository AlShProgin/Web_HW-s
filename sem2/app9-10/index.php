<?php

require __DIR__ . "/vendor/autoload.php";
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
spl_autoload_register(function ($class){
    include "./classes/" . $class . '.php';
});
include "./Controller.php";

$controller = new Controller();
$controller->operate();
