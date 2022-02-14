<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\AgentRepository;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionsController extends AbstractController
{
    /**
     * @Route("/admin/missions", name="admin_missions_list")
     */
    public function adminMissionsList(MissionRepository $missionRepository): Response
    {
        $missionsAdmin = $missionRepository->findAll();

        return $this->render('admin/missionsList.html.twig', [
            'missions' => $missionsAdmin
        ]);
    }




    /**
     * @Route("/admin/missions/delete/{id}", name="admin_missions_liste_delete")
     */
    public function adminMissionsDelete($id, MissionRepository $missionRepository, EntityManagerInterface $entityManager): Response
    {
        $mission = $missionRepository->find($id);

        $entityManager->remove($mission);
        $entityManager->flush();

        return $this->redirectToRoute('admin_missions_list');
    }

    /**
     * @Route("/admin/missions/insert", name="admin_missions_liste_insert")
     */
    public function adminMissionsInsert(EntityManagerInterface $entityManager, Request $request): Response
    {
        $mission = new Mission();

        $missionForm = $this->createForm(MissionType::class, $mission);

        //lier le formulaire aux données de la requête
        $missionForm->handleRequest($request);

        if($missionForm->isSubmitted() && $missionForm->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();
            return $this->redirectToRoute('admin_missions_list');
            }

        return $this->render('admin/missionsInsert.html.twig', [
            'missionForm' => $missionForm->createView()
        ]);
    }


        /**
         * @Route("/admin/missions/update/{id}", name="admin_missions_liste_update")
         */
        public function adminMissionsUpdate($id, MissionRepository $missionRepository, EntityManagerInterface $entityManager, Request $request): Response
        {
            $mission = $missionRepository->find($id);

            $missionForm = $this->createForm(MissionType::class, $mission);

            //lier le formulaire aux données de la requête
            $missionForm->handleRequest($request);

            if ($missionForm->isSubmitted() && $missionForm->isValid()) {
                $entityManager->persist($mission);
                $entityManager->flush();
                return $this->redirectToRoute('admin_missions_list');

            }

            return $this->render('admin/missionsInsert.html.twig', [
                'missionForm' => $missionForm->createView()
            ]);
        }




    /**
     * @Route("/search", name="mission_search")
     */
    public function search(MissionRepository $missionRepository, Request $request)
    {
        $term = $request->query->get('q');

        $missions = $missionRepository->searchByTerm($term);

        return $this->render('admin/missionsSearch.html.twig', [
            'missionsSearch' =>$missions
        ]);
    }



}