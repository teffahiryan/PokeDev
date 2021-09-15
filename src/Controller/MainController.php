<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Equipe;
use App\Entity\Pokemon;
use App\Entity\CatchPokemon;
use App\Form\ChooseStarterType;
use App\Repository\BotRepository;
use App\Repository\CatchPokemonRepository;
use App\Repository\UserRepository;
use App\Repository\EquipeRepository;
use App\Repository\PokemonRepository;
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
    public function newGame(Request $request,UserRepository $userRepository): Response
    {
        // CREATION EQUIPE
        $user = $this->getUser();
        $userMail = $this->getUser()->getEmail();
        $userEID = $this->getUser()->getEquipeId();

        if($userEID == null){
            $equipe = new Equipe();
            $equipe->setTrainer($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();  
        }

        // CHOIX POKEMON

        $catchPokemon = new CatchPokemon();
        $catchPokemon->setUserId($user);
        $catchPokemon->setEquipeId($userEID);
        $form = $this->createForm(ChooseStarterType::class, $catchPokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catchPokemon);
            $entityManager->flush();

            return $this->redirectToRoute('app_game', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/start.html.twig', [
            'catch_pokemon' => $catchPokemon,
            'form' => $form,
        ]);
    }
    
    #[Route('/game', name: 'app_game')]
    public function game(UserRepository $userRepository, CatchPokemonRepository $catchPokemonRepository, PokemonRepository $pokemonRepository): Response
    {

        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $userEID = $this->getUser()->getEquipeId();

        $arrayPokemon = array();
        $listPokemonId = $catchPokemonRepository->findBy(['userId' => $userId, 'equipeId' => $userEID]);

        foreach( $listPokemonId as $key => $value){
            $pokemonId = $value->getPokemonId();
            $pokemonName = $pokemonRepository->findOneBy(['id' => $pokemonId]);
            $pokemonName = $pokemonName->getName();
            array_push($arrayPokemon, $pokemonName);
        }
        
        return $this->render('game/index.html.twig', [
            'controller_name' => 'MainController',
            'catch_pokemon' => $arrayPokemon,
        ]);

    }

    #[Route('/game/combat/trainer', name: 'app_game_cbt_trainer')]
    public function trainerCombat(UserRepository $userRepository, PokemonRepository $pokemonRepository , BotRepository $botRepository, CatchPokemonRepository $catchPokemonRepository): Response
    {

        if($user = $this->getUser() ){
            $userEquipe = $user->getUserIdentifier();
            $userRepository = $userRepository->findOneBy(['email' => $userEquipe]);
            $userRepository = $userRepository->getEquipeId();
            $username = $user->getPseudo();
        }

        // TRAINER
        
        $userId = $this->getUser()->getId();
        $userEID = $this->getUser()->getEquipeId();
        $arrayPokemon = array();
        $listPokemonId = $catchPokemonRepository->findBy(['userId' => $userId, 'equipeId' => $userEID]);

        foreach( $listPokemonId as $key => $value){
            $pokemonId = $value->getPokemonId();
            $pokemonName = $pokemonRepository->findOneBy(['id' => $pokemonId]);
            $pokemonName = $pokemonName->getName();
            array_push($arrayPokemon, $pokemonName);
        }

        // BOT TRAINER

        $lengthPkmn = count($pokemonRepository->findAll());
        $random_value_pkmn = random_int(1, $lengthPkmn);
        $listPokemonBotId = $pokemonRepository->findOneBy(['id' => $random_value_pkmn]);

        $lengthBot = count($botRepository->findAll());
        $random_value_bot = random_int(1, $lengthBot);
        $bot = $botRepository->findOneBy(['id'=> $random_value_bot ]);
        $botUsername = $bot->getName();

        return $this->render('game/trainer_combat.html.twig', [
            'controller_name' => 'MainController',
            'random_bot' => $bot,
            'random_bot_username' => $botUsername,
            'listTrainerBotPkmn' => $listPokemonBotId,
            'username' => $username,
            'listTrainerPkmn' => $listPokemonId,

        ]);

    }

    #[Route('/game/combat/savage', name: 'app_game_cbt_savage')]
    public function savageCombat(UserRepository $userRepository): Response
    {

        if($user = $this->getUser() ){
            $userEquipe = $user->getUserIdentifier();
            $userRepository = $userRepository->findOneBy(['email' => $userEquipe]);
            $userRepository = $userRepository->getEquipeId();
        }

        return $this->render('game/savage_combat.html.twig', [
            'controller_name' => 'MainController',
            'equipeId' => $userRepository,
        ]);

    }
}
