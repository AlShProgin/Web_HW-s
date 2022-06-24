<?php

// src/Controller/Controller_loggedOut.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Chat;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Controller_loggedIn extends AbstractController {
    /**
    * @Route("/loggedIn", name="app_loginPage")
    */
    public function number(ManagerRegistry $doctrine): Response {
        if(isset($_COOKIE['user'])) { $username = $_COOKIE['user']; }
        else{
            setcookie("error_code",'2');
            return $this->redirectToRoute('app_logoutPage');
        }
        
        $repository_chat = $doctrine->getRepository(Chat::class);
        $chats = $repository_chat->findAll();
        $chatIDs = array();
        foreach($chats as $chat){
            $chatIDs[] = array(
                'id'=> (string)$chat->getId(),
                'title'=> $chat->getTitle()
            );
        }
        if(count($chatIDs) == 0) { $chatIDs = null; }
        $notification=null;
        $messages = null;
        $messageLabel = null;
        
        if(isset($_POST['b_formMessage'])){
        	$action = $_POST['b_formMessage'];
        	$entityManager = $doctrine->getManager();
                $repository_msg = $doctrine->getRepository(Message::class);
                $repository_user = $doctrine->getRepository(User::class);
                $user = $repository_user->findOneBy(['name' => $username]);
		switch ($action){
		    case "Show all":#--------------------
		        $messages_rep = $repository_msg->findAll();
		        $messages = array();
		        foreach($messages_rep as $message) {
		            if($message->getChat()) { continue; }
		            $messages[] = array(
		                'name'=>$repository_user->find($message->getName())->getName(),
		                'content'=>$message->getContent()
		            );
		        }
		        if(!$messages){
		            $notification = 'No messages found';
		            $messages = null;
		        }
		        $messageLabel = 'Forum\'s message history';
			break;
		    case "Show mine":#--------------------
		        $messages_rep = $repository_msg->findBy(['name'=>$user]);
		        $messages = array();
		        foreach($messages_rep as $message){
		            if($message->getChat()) { continue; }
		            $messages[] = array(
		                'name'=> $repository_user->find($message->getName())->getName(),
		                'content'=> $message->getContent()
		            );
		        }
		        if(!$messages){
		            $notification = "No messages found";
		            $messages = null;
		        }
                        $messageLabel = 'My message history';
			break;
		    case "Post":#--------------------
		        $content = $_POST['text_1'];
		        if($content == ""){
		          $notification = 'No message entered';
		          break;
		        }
		        $user = $repository_user->findOneBy(['name' => $username]);
		        $msg = new Message();
		        $msg->setName($user);
		        $msg->setContent($content);
		        $entityManager->persist($msg);
		        $entityManager->flush();
		        $messages = null;
			break;
		    default:
		}
	}
	return $this->render('LoggedIn.twig', 
                ['username'=>$username,
                'messageLabel'=>$messageLabel,
                'messages'=>$messages,
                'notification'=>$notification,
                'chats'=>$chatIDs
                ]); 
    }
}
