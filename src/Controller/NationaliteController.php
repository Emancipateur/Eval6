<?php

namespace App\Controller;

use App\Entity\Nationalite;
use App\Form\NationaliteType;
use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/nationalite')]
class NationaliteController extends AbstractController
{
    #[Route('/', name: 'nationalite_index', methods: ['GET'])]
    public function index(NationaliteRepository $nationaliteRepository): Response
    {
        return $this->render('nationalite/index.html.twig', [
            'nationalites' => $nationaliteRepository->findAll(),
        ]);
    }

    #[Route('/admin/nationalite/new', name: 'nationalite_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $nationalite = new Nationalite();
        $form = $this->createForm(NationaliteType::class, $nationalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nationalite);
            $entityManager->flush();

            return $this->redirectToRoute('nationalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nationalite/new.html.twig', [
            'nationalite' => $nationalite,
            'form' => $form,
        ]);
    }

    #[Route('/admin/nationalite/{id}', name: 'nationalite_show', methods: ['GET'])]
    public function show(Nationalite $nationalite): Response
    {
        return $this->render('nationalite/show.html.twig', [
            'nationalite' => $nationalite,
        ]);
    }

    #[Route('/admin/nationalite/{id}/edit', name: 'nationalite_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Nationalite $nationalite): Response
    {
        $form = $this->createForm(NationaliteType::class, $nationalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nationalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nationalite/edit.html.twig', [
            'nationalite' => $nationalite,
            'form' => $form,
        ]);
    }

    #[Route('/admin/nationalite/{id}', name: 'nationalite_delete', methods: ['POST'])]
    public function delete(Request $request, Nationalite $nationalite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nationalite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nationalite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nationalite_index', [], Response::HTTP_SEE_OTHER);
    }
}
