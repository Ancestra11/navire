<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(): Response
    {
        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
        ]);
    }
    
    #[Route('/imo/{imoFromController}', name:'imo')]
    public function redirectImo(string $imoFromController) : Response {
        return $this->render('recherche/imo.html.twig', compact('imoFromController'));
    }
    
    #[Route('/mmsi/{mmsiFromController}', name:'mmsi')]
    public function redirectMmsi(string $mmsiFromController) : Response {
        return $this->render('recherche/mmsi.html.twig', compact('mmsiFromController'));
    }
}
