<?php

namespace App\Controller;

use App\Entity\TypePlanque;
use App\Form\TypePlanqueType;
use App\Repository\TypeplanqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/planque')]
class TypePlanqueController extends AbstractController
{
    #[Route('/', name: 'type_planque_index', methods: ['GET'])]
    public function index(TypeplanqueRepository $typeplanqueRepository): Response
    {
        return $this->render('type_planque/index.html.twig', [
            'type_planques' => $typeplanqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'type_planque_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $typePlanque = new TypePlanque();
        $form = $this->createForm(TypePlanqueType::class, $typePlanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePlanque);
            $entityManager->flush();

            return $this->redirectToRoute('type_planque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_planque/new.html.twig', [
            'type_planque' => $typePlanque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_planque_show', methods: ['GET'])]
    public function show(TypePlanque $typePlanque): Response
    {
        return $this->render('type_planque/show.html.twig', [
            'type_planque' => $typePlanque,
        ]);
    }

    #[Route('/{id}/edit', name: 'type_planque_edit', methods: ['GET','POST'])]
    public function edit(Request $request, TypePlanque $typePlanque): Response
    {
        $form = $this->createForm(TypePlanqueType::class, $typePlanque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_planque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_planque/edit.html.twig', [
            'type_planque' => $typePlanque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'type_planque_delete', methods: ['POST'])]
    public function delete(Request $request, TypePlanque $typePlanque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePlanque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePlanque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_planque_index', [], Response::HTTP_SEE_OTHER);
    }
}
