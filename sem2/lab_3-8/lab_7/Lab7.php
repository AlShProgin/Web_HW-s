<?php
require __DIR__ . "/vendor/autoload.php";
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

try{
    $db = new PDO('mysql:host=localhost;dbname=testDB', 'sasha', 'rootroot');
    $result = $db->query('SELECT * FROM users');
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    echo "Already existing users:<br>";
    foreach($rows as $row){
    	$uname = $row['username'];
        echo "$uname<br>";
    }
    $loader = new FilesystemLoader(__DIR__ . "/templates");
    $twig = new Environment($loader);
    echo $twig->render('lab7_form.twig');
    if(isset($_GET["inputName"]) && isset($_GET["inputPassword"])) {
        $uname = $_GET["inputName"];
        $upassword = $_GET["inputPassword"];

        $insert_query = $db->prepare("INSERT INTO users (username, password) VALUES (\"$uname\",\"$upassword\")");
        $insert_query->execute();
        echo $twig->render('lab7_newUser.twig', ['username' => $uname, 'password' => $upassword]);
    }
    
} catch (PDOException $e) {
  print "<br>Error!: " . $e->getMessage();
  die();
} catch (Exception $ex) {
  print "<br>Error!: " . $ex->getMessage();
  die();
}


/*
foreach($uname in $sth){
    echo '$uname';
}

$dbh = null;
$stmt = null;
*/
