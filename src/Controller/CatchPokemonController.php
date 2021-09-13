<?php

namespace App\Controller;

use App\Entity\CatchPokemon;
use App\Form\CatchPokemonType;
use App\Repository\CatchPokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catch/pokemon')]
class CatchPokemonController extends AbstractController
{
    #[Route('/', name: 'catch_pokemon_index', methods: ['GET'])]
    public function index(CatchPokemonRepository $catchPokemonRepository): Response
    {
        return $this->render('catch_pokemon/index.html.twig', [
            'catch_pokemons' => $catchPokemonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'catch_pokemon_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $catchPokemon = new CatchPokemon();
        $form = $this->createForm(CatchPokemonType::class, $catchPokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catchPokemon);
            $entityManager->flush();

            return $this->redirectToRoute('catch_pokemon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('catch_pokemon/new.html.twig', [
            'catch_pokemon' => $catchPokemon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'catch_pokemon_show', methods: ['GET'])]
    public function show(CatchPokemon $catchPokemon): Response
    {
        return $this->render('catch_pokemon/show.html.twig', [
            'catch_pokemon' => $catchPokemon,
        ]);
    }

    #[Route('/{id}/edit', name: 'catch_pokemon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CatchPokemon $catchPokemon): Response
    {
        $form = $this->createForm(CatchPokemonType::class, $catchPokemon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('catch_pokemon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('catch_pokemon/edit.html.twig', [
            'catch_pokemon' => $catchPokemon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'catch_pokemon_delete', methods: ['POST'])]
    public function delete(Request $request, CatchPokemon $catchPokemon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catchPokemon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($catchPokemon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catch_pokemon_index', [], Response::HTTP_SEE_OTHER);
    }
}
