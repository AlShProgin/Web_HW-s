<?php
spl_autoload_register(function ($class){
    include "./classes/" . $class . '.php';
});

$test1 = new TestClass1();
$test1->info();
$test2 = new TestClass2();
$test2->info();
