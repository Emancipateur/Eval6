<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function missionsList(MissionRepository $missionRepository): Response
    {
        $missions = $missionRepository->findAll();

        return $this->render('accueil.html.twig', [
            'missions'=>$missions
        ]);
    }
}