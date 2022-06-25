<?php

use PDO;
class TestClass1{
    public $db;
    public $username;
    
    public function construcn(){
        $db = new PDO('mysql:host=localhost;dbname=testDB', 'sasha', 'rootroot');
    }

    public function info(){
        echo "<br>Received an object of TestClass1";
    }
}
