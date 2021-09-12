<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Equipe;
use App\Form\ChooseStarterType;
use App\Repository\UserRepository;
use App\Repository\EquipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserRepository $userRepository): Response
    {

        if($user = $this->getUser() ){
            $userEquipe = $user->getUserIdentifier();
            $userRepository = $userRepository->findOneBy(['email' => $userEquipe]);
            $userRepository = $userRepository->getEquipeId();
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'equipeId' => $userRepository,
        ]);

    }

    #[Route('/game/new', name: 'app_new_game', methods: ['GET', 'POST'])]
    public function newGame(Request $request): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(ChooseStarterType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_game', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/start.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }
    
    #[Route('/game', name: 'app_game')]
    public function game(UserRepository $userRepository): Response
    {

        if($user = $this->getUser() ){
            $userEquipe = $user->getUserIdentifier();
            $userRepository = $userRepository->findOneBy(['email' => $userEquipe]);
            $userRepository = $userRepository->getEquipeId();
        }

        return $this->render('game/index.html.twig', [
            'controller_name' => 'MainController',
            'equipeId' => $userRepository,
        ]);

    }
}
