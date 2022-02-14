<?php

namespace App\Controller;

use App\Entity\TypeMission;
use App\Form\TypesMissionType;
use App\Repository\TypesMissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/types/mission')]
class TypesMissionController extends AbstractController
{
    #[Route('/', name: 'types_mission_index', methods: ['GET'])]
    public function index(TypesMissionRepository $typesMissionRepository): Response
    {
        return $this->render('types_mission/index.html.twig', [
            'types_missions' => $typesMissionRepository->findAll(),
        ]);
    }

    #[Route('/admin/types/mission/new', name: 'types_mission_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $typesMission = new TypeMission();
        $form = $this->createForm(TypesMissionType::class, $typesMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typesMission);
            $entityManager->flush();

            return $this->redirectToRoute('types_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_mission/new.html.twig', [
            'types_mission' => $typesMission,
            'form' => $form,
        ]);
    }

    #[Route('/admin/types/mission/{id}', name: 'types_mission_show', methods: ['GET'])]
    public function show(TypeMission $typesMission): Response
    {
        return $this->render('types_mission/show.html.twig', [
            'types_mission' => $typesMission,
        ]);
    }

    #[Route('/admin/types/mission/{id}/edit', name: 'types_mission_edit', methods: ['GET','POST'])]
    public function edit(Request $request, TypeMission $typesMission): Response
    {
        $form = $this->createForm(TypesMissionType::class, $typesMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('types_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_mission/edit.html.twig', [
            'types_mission' => $typesMission,
            'form' => $form,
        ]);
    }

    #[Route('/admin/types/mission/{id}', name: 'types_mission_delete', methods: ['POST'])]
    public function delete(Request $request, TypeMission $typesMission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typesMission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typesMission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('types_mission_index', [], Response::HTTP_SEE_OTHER);
    }
}
