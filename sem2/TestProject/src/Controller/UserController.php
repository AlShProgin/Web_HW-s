<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class UserController extends AbstractController {
    #[Route('/user', name: 'app_user')]
    public function createUser(ManagerRegistry $doctrine): Response {
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findBy(['name' => 'test subject']);
        if ($user) {
            return new Response('User with id ' . $user[0]->getId() . ' already exists');
        }
        else{
            $user = $repository->findOneBy(['name' => 'test subject']);
            #$user = new User();
            #$user->setName('Test Subject');
            #$user->setPassword('test');
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($user);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            return new Response('Saved new user with id '.$user->getId());
        }

        
    }
    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response {
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->find($id);

        if (!$user) {
            return new Response('User with id '.$user->getId().' does not exist');
        }
        if ($user->getId() == 1){
            if ($user->getName() == 'test subject'){
                return new Response('User '.' is already '.$user->getName());
            }
            return new Response('User with id '.$user->getId().' is now '.$user->getName());
        }
        return new Response('Check out this user whose id != 1 ');

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
