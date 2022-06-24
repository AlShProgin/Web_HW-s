<?php

// src/Controller/Controller_loggedOut.php
namespace App\Controller;

#use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller_signIn extends AbstractController {
    /**
    * @Route("/signIn", name="app_signInPage")
    */
    public function signIn(ManagerRegistry $doctrine): Response { 
        if(isset($_POST['b_formSignIn'])) {
            $repository = $doctrine->getRepository(User::class);
	    $name = $_POST['formSignIn_name'];
	    $password = $_POST['formSignIn_password'];
	    #If no name entered
            if($name === ""){
                return $this->render('signIn.twig', ['warning'=>'No username entered']);
            }
            #If no password entered
            if($password === ""){
                return $this->render('signIn.twig', ['warning'=>'No password entered']);
            }
	    $user = $repository->findOneBy(['name' => $name]);
	    #if user already exists
	    if($user) { 
	        return $this->render('signIn.twig', ['warning'=>'User \''.$name.'\' already exists']);
	    }
	    #if the username is vacant
	    else {
	        $user = new User();
                $user->setName($name);
                $user->setPassword($password);
                
                if (strlen($name)>40 || strlen($name)>40) {
                    return $this->render('signIn.twig', ['warning'=>'Username and/or password too long - use <=40symbols']);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                #created a user and immediately logged in with his name
                setcookie("user", $name);
	        return $this->redirectToRoute('app_loginPage');
                #return $this->render('signIn.twig', ['warning'=>'Created user \''.$name.'\'']);
	    } 
        }
        #if the login button is NOT pressed
        else { 
            return $this->render('signIn.twig', ['warning'=>null]);
        }

    }
}
