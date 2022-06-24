<?php

// src/Controller/Controller_loggedOut.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\ErrorCode;

class Controller_loggedOut extends AbstractController {
    /**
     * @Route("/loggedOut", name="app_logoutPage")
     */
    public function tryLogin(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        #handling error with a code passed through cookies
        if(isset($_COOKIE['error_code'])){
            $entityManager = $doctrine->getManager();
            $repository = $doctrine->getRepository(ErrorCode::class);
            $error_code = $repository->find(2);
            $desc = null;
            if($error_code){
                $desc = $error_code->getErrorDesc();
                return $this->render('LoggedOut.twig', ['warning'=>$desc]);
            }
            setcookie('error_code',0);
            
        }
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
    #----------------------------------------------------------------------------------------
    /**
     * @Route("/loggedOut/{error_id}", name="app_logoutPageExternalError")
     */
     #special route for managing errors with id's from error_code table;
     public function handleError(ManagerRegistry $doctrine, $error_id){
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(ErrorCode::class);
        $error_code = $repository->find(1);
        if(!$error_code){
            return $this->render('LoggedOut.twig', ['warning' => 'ERROR: '.'received an inknown eror code']);
        }
        else{
            return $this->render('LoggedOut.twig', ['warning' => 'ERROR: '.$error_code->getErrorDesc()]);
        }  
     }
}
