<?php

// src/Controller/Controller_loggedOut.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\UsernameRecord;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller_profile extends AbstractController {
    /**
    * @Route("/Profile", name="app_ProfilePage")
    */
    public function number(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(User::class);
        $username = $_COOKIE['user'];
        $currentUser = $repository->findOneBy(['name'=>$username]);
        $notification = null;
        $change = null;
        $nameRecord = null;
        
        $repository_rec = $doctrine->getRepository(UsernameRecord::class);
	$nameRecords = $repository_rec->FindBy(['user'=>$currentUser]);
	$nameRecord = array();
	foreach($nameRecords as $record){
	    $nameRecord[] = array(
	    'name'=>$record->getNameEntry()
	    );
	}
	    if(count($nameRecord) == 0) { $nameRecord = null; }
	
	if(isset($_POST['profile_submit'])) {
		$action = $_POST['profile_submit'];
		$entityManager = $doctrine->getManager();
		
		switch ($action){
		    case "Change name":#--------------------
			$change = array('name' => true, 'password' => false);
			setcookie('ChangeMode','name');
			break;
		    case "Change password":#--------------------
			$change = array('name' => false, 'password' => true);
			setcookie('ChangeMode','password');       
			break;
		    case "Confirm":#--------------------
		        if(isset($_COOKIE['ChangeMode'])){
		            $mode = $_COOKIE['ChangeMode'];
		        }
		        else{
		            $notification = "Failed to read the change mode";
		            break;
		        }
		        switch ($mode){
		            case 'name':
		                $name = $_POST['profile_name'];
		                if(strlen($name) == 0){
		                    $notification = "No new name provided";
		                    break;
		                }
		                $user = $repository->findOneBy(['name'=>$name]);
		                if($user){
		                    $notification = "This name is already used";
		                    break;
		                }
		                if(!$currentUser){
		                    setcookie("error_code",'2');
            			    return $this->redirectToRoute('app_logoutPage');
		                }
		                
		                if(!$repository_rec->findBy(['user'=>$currentUser, 'name_entry'=>$username])) {
		                    $record = new UsernameRecord();
		                    $record->setUser($currentUser);
		                    $record->setNameEntry($username);
		                    $entityManager->persist($record);
		                }
		                
		                $currentUser->setName($name);
		                $entityManager->persist($currentUser);
		                setcookie('user', $name);
		                $username = $name;
		                
		                $entityManager->flush();
		                $notification = "Username changed";
		                break;
		            case 'password':
		                if(!$currentUser){
		                    setcookie("error_code",'2');
            			    return $this->redirectToRoute('app_logoutPage');
		                }
		                if($currentUser->getPassword() != $_POST['profile_oldpassword']){
		                    $notification = "Incorrect current password";
		                    break;
		                }
		                $password = $_POST['profile_newpassword'];
		                if(strlen($password) == 0){
		                    $notification = "New password not provided";
		                    break;
		                }
		                
		                $currentUser->setPassword($password);
		                $entityManager->persist($currentUser);
		                $entityManager->flush();
		                $notification = "Password changed";
		                break;
		            default:
		                $notification = "Unexpected change mode";
		        }
			break;
		    default:
		        $notification = "Unexpected value for an attribute to change";
		}

	}

	return $this->render('Profile.twig', 
	    ['username' => $username, 
	    'notification'=>$notification,
	    'change'=>$change,
	    'records'=>$nameRecord
	    ]);  
    }
}
