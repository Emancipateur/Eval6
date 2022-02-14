<?php

namespace App\Controller;

use App\Entity\Planque;
use App\Form\PlanqueType;
use App\Repository\PlanqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/planque')]
class PlanqueController extends AbstractController
{
    #[Route('/', name: 'planque_index', methods: ['GET'])]
    public function index(PlanqueRepository $planqueRepository): Response
    {
        return $this->render('planque/index.html.twig', [
            'planques' => $planqueRepository->findAll(),
        ]);
    }

    #[Route('/admin/planque/new', name: 'planque_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $planque = new Planque();
        $form = $this->createForm(PlanqueType::class, $planque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($planque);
            $entityManager->flush();

            return $this->redirectToRoute('planque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planque/new.html.twig', [
            'planque' => $planque,
            'form' => $form,
        ]);
    }

    #[Route('/admin/planque/{id}', name: 'planque_show', methods: ['GET'])]
    public function show(Planque $planque): Response
    {
        return $this->render('planque/show.html.twig', [
            'planque' => $planque,
        ]);
    }

    #[Route('/admin/planque/{id}/edit', name: 'planque_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Planque $planque): Response
    {
        $form = $this->createForm(PlanqueType::class, $planque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planque/edit.html.twig', [
            'planque' => $planque,
            'form' => $form,
        ]);
    }

    #[Route('/admin/planque/{id}', name: 'planque_delete', methods: ['POST'])]
    public function delete(Request $request, Planque $planque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($planque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planque_index', [], Response::HTTP_SEE_OTHER);
    }
}
