<?php

namespace App\Controller;

use App\Entity\Attack;
use App\Form\AttackType;
use App\Repository\AttackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/attack')]
class AttackController extends AbstractController
{
    #[Route('/', name: 'attack_index', methods: ['GET'])]
    public function index(AttackRepository $attackRepository): Response
    {
        return $this->render('admin/attack/index.html.twig', [
            'attacks' => $attackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'attack_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $attack = new Attack();
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attack);
            $entityManager->flush();

            return $this->redirectToRoute('attack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/attack/new.html.twig', [
            'attack' => $attack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'attack_show', methods: ['GET'])]
    public function show(Attack $attack): Response
    {
        return $this->render('admin/attack/show.html.twig', [
            'attack' => $attack,
        ]);
    }

    #[Route('/{id}/edit', name: 'attack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Attack $attack): Response
    {
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/attack/edit.html.twig', [
            'attack' => $attack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'attack_delete', methods: ['POST'])]
    public function delete(Request $request, Attack $attack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attack_index', [], Response::HTTP_SEE_OTHER);
    }
}
