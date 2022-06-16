<?php

require __DIR__ . "/vendor/autoload.php";
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

spl_autoload_register(function ($class){
    include "./classes/" . $class . '.php';
});

class Controller {
    private $loader;
    private $twig;
    public $repository;
    
    public function __construct(){
        $this->loader = new FilesystemLoader(__DIR__ . "/templates");
        $this->twig = new Environment($this->loader);
        $this->repository = new MessageRepository();
        $this->currUser = $_COOKIE['user'];
    }
    public function operate(){
        switch ($_COOKIE['mode']){
            case null:
            	setcookie("mode", 'Logged out');
                echo $this->twig->render('lab9_formMode.twig');
                break;
	    case 'Logged out':
		$this->handle_loggedOut();
		break;
	    case 'Logged in':
	        $this->handle_LoggedIn();
		break;
	    default:
	        setcookie("mode", 'Logged out');
	        echo $this->twig->render('lab9_formMode.twig');
	        echo "<br>Unexpected status";
	}
	echo "<br><br><b>Status:</b> ". $_COOKIE['mode'];
    }
    public function handle_loggedOut(){
        if(isset($_POST['B_Login'])) {
	    $name = $_POST['FormAuth_Username'];
	    $password = $_POST['FormAuth_Password'];
	    $user = new User();
	    if($user->IsReal($name, $password)) { 
	        setcookie("user", $name);
	        setcookie("mode", 'Logged in');
	        echo $this->twig->render('lab9_formMessages.twig', ['username' => $name]);
	    }
	    else { 
	        setcookie("mode", 'Logged out');
	        echo $this->twig->render('lab9_formMode.twig');
	    } 
        }
        else { 
            setcookie("mode", 'Logged out');
            echo $this->twig->render('lab9_formMode.twig');
        }
    }
    
    public function handle_LoggedIn(){
        $action = $_POST['b_formMessage'];
        $currUser = $_COOKIE['user'];
        
	switch ($action){
	    case "Search All":#--------------------
	        echo $this->twig->render('lab9_formMessages.twig', ['username'=>$currUser]);
		$this->showAllMessages();
		break;
	    case "Search mine":#--------------------
	        echo $this->twig->render('lab9_formMessages.twig', ['username'=>$currUser]);
	    	$attr = $_POST['text_1'];
		$rows = $this->repository->searchAttr($_COOKIE['user']);
		if(count($rows) == 0) {
		    echo "<br>No elements of type $type with value $attr";
		    break;
		}
		echo "<br><b>Messaged by <i>$attr</i>:</b>";
		foreach($rows as $row){
		   $name = $row->getUsername();
		   $content = $row->getContent();
		   echo "<br><b>$name:</b> $content"; 
		}
		break;
	    case "Insert":#--------------------
	        echo $this->twig->render('lab9_formMessages.twig', ['username'=>$currUser]);
		$content = $_POST['text_1'];
		if($content == "" || is_null($content)) {
		    echo "<br>Received an invalid message";
		    break;
		}
		$this->repository->insert(new Message(null, $currUser, $content)); 
		$this->showAllMessages();
		break;
	    case "Delete":#--------------------
	        echo $this->twig->render('lab9_formMessages.twig', ['username'=>$currUser]);
		$this->repository->deleteForUsername($currUser);
		$this->showAllMessages();
		break;
	    case "Log out":#--------------------
	        setcookie("mode", "Logged out");
	        setcookie("user", null);
	        echo $this->twig->render('lab9_formMode.twig');
		break;
	    default:
	        echo $this->twig->render('lab9_formMessages.twig', ['username'=>$currUser]);
	        echo "<br>No options chosen";
	}
    }
    private function showAllMessages(){
        $rows = $this->repository->searchAll();
	if(count($rows) == 0) {
		echo "<br>No elements found";
		return;
	}
	echo "<br><b>Showing list of all messages:</b>";
	foreach($rows as $row){
	    $name = $row->getUsername();
	    $content = $row->getContent();
	    echo "<br><b>$name:</b> $content"; 
	}
    }
}

