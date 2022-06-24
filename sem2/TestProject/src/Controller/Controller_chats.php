<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\UserChatList;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller_chats extends AbstractController {
    /**
     * @Route("/chat/{id}", name="app_ChatPage")
     */
    public function renderChat(ManagerRegistry $doctrine, $id): Response {
        $entityManager = $doctrine->getManager();
        $repository_chat = $doctrine->getRepository(Chat::class);
        $repository_usr = $doctrine->getRepository(User::class);
        $repository_msg = $doctrine->getRepository(Message::class);
        $repository_chatList = $doctrine->getRepository(UserChatList::class);
    
        $chat = $repository_chat->find($id);
        $title = $chat->getTitle();
        $messages_rep = $repository_msg->findBy(['chat'=>$chat]);
        $messages = array();
        for($i=0; $i<count($messages_rep); $i++){
            $messages[] = array(
	        'name'=>$repository_usr->find($messages_rep[$i]->getName())->getName(),
	        'content'=>$messages_rep[$i]->getContent()
	    );
	}
	if(!$messages){
	    $messages = null;
	}
        
        return $this->render('chat.twig', 
        ['title'=>$title,
        'messages'=>$messages
        ]);

        #if the login button is pressed
        if(isset($_POST['B_Login'])) {
            $repository = $doctrine->getRepository(User::class);
	    $name = $_POST['FormAuth_Username'];
	    $password = $_POST['FormAuth_Password'];
	    $user = $repository->findOneBy(['name' => $name]);
	    #if no user with the name found
	    if(!$user) { 
	        return $this->render('LoggedOut.twig', ['warning'=>'No user with name '.$name.' found']);
	    }
	    #if the user is found
	    else {
	        #if correct password
	        if($user->getPassword() == $password){
	            setcookie("user", $name);
	            return $this->redirectToRoute('app_loginPage');
	        }
	        #if incorrect password
	        else{ 
	            return $this->render('LoggedOut.twig', ['warning'=>'incorrect password']);
	        }
	    } 
        }
        #if the login button is NOT pressed
        else { 
            return $this->render('LoggedOut.twig', ['warning'=>null]);
        }
    }
}
