<?php

spl_autoload_register(function ($class){
    include "./classes/" . $class . '.php';
});
require __DIR__ . "/vendor/autoload.php";
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


$loader = new FilesystemLoader(__DIR__ . "/templates");
$twig = new Environment($loader);
$buttonList = array(
    'b_searchAll',
    'b_searchParameter',
    'b_insert',
    'b_delete',
    'b_update'
);

$activeButton;
for($i = 1; $i<=5; $i++){
    $buttonName = array_shift($buttonList);
    if(isset($_POST[$buttonName])) {
        $activeButton = $i;
        unset($_POST[$buttonName]);
        break;
    }
}
$user = new Users();

switch ($activeButton){
    case 1:
        $rows = $user->searchAll();
        if(count($rows) == 0) {
            echo "<br>No elements found";
            break;
        }
        echo "<br><b>Showing list of all users:</b>";
        foreach($rows as $row){
           $uname = $row['username'];
           $upassword = $row['password'];
           echo "<br><b>Username:</b> $uname, <b>Password:</b> $upassword"; 
        }
        break;
    case 2:
        $type = $_POST['text_1'];
        $attr = $_POST['text_2'];
        $rows = $user->searchAttr($type, $attr);
        if(count($rows) == 0) {
            echo "<br>No elements of type $type with value $attr";
            break;
        }
        echo "<br><b>Showing list of users:</b>";
        foreach($rows as $row){
           $uname = $row['username'];
           $upassword = $row['password'];
           echo "<br><b>Username:</b> $uname, <b>Password:</b> $upassword"; 
        }
        break;
    case 3:
        $name = $_POST['text_1'];
        $password = $_POST['text_2'];
        $isCorrect = $user->insert($name, $password);
        if($isCorrect) { echo "<br>Insertion complete"; }
        else { echo "<br>Insertion failed"; }
        break;
    case 4:
        $name = $_POST['text_1'];
        $password = $_POST['text_2'];
        $isCorrect = $user->insert($name, $password);
        if($isCorrect) { echo "<br>Insertion complete"; }
        else { echo "<br>Insertion failed"; }
        break;
    case 5:
        $attrName = $_POST['text_1'];
        $name = $_POST['text_2'];
        $attr_old = $_POST['text_3'];
        $attr_new = $_POST['text_4'];
        
        $isCorrect = $user->update($attrName, $name, $attr_old, $attr_new);
        if($isCorrect) { echo "<br>Update complete"; }
        else { echo "<br>Update failed"; }
        break;
    default:
        echo "Unexpected result";
}


echo $twig->render('lab8_formMode.twig');

/*
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

$dbh = null;
$stmt = null;
*/
