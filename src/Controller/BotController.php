<?php

namespace App\Controller;

use App\Entity\Bot;
use App\Form\BotType;
use App\Entity\Equipe;
use App\Repository\BotRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/bot')]
class BotController extends AbstractController
{
    #[Route('/', name: 'bot_index', methods: ['GET'])]
    public function index(BotRepository $botRepository): Response
    {
        return $this->render('admin/bot/index.html.twig', [
            'bots' => $botRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'bot_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $bot = new Bot();
        $form = $this->createForm(BotType::class, $bot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipe = new Equipe();
            $equipe->setBotTrainer($bot);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipe);
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bot);
            $entityManager->flush();

            return $this->redirectToRoute('bot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/bot/new.html.twig', [
            'bot' => $bot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bot_show', methods: ['GET'])]
    public function show(Bot $bot): Response
    {
        return $this->render('admin/bot/show.html.twig', [
            'bot' => $bot,
        ]);
    }

    #[Route('/{id}/edit', name: 'bot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bot $bot): Response
    {
        $form = $this->createForm(BotType::class, $bot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/bot/edit.html.twig', [
            'bot' => $bot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'bot_delete', methods: ['POST'])]
    public function delete(Request $request, Bot $bot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bot_index', [], Response::HTTP_SEE_OTHER);
    }
}
