<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AisShipTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Port;
use App\Entity\Pays;

#[Route('/aisshiptype', name: 'aisshiptype ')]
class AisShipTypeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('aisshiptype/index.html.twig', [
            'controller_name' => 'AisShipTypeController',
        ]);
    }
    
    #[Route('/voirtous', name:'voirtous')]
    public function voirTous(AisShipTypeRepository $repoAisShipType): Response {
        $aisShipTypes = $repoAisShipType->findAll();
        return $this->render('aisshiptype/voirtous.html.twig', [
            'aisShipTypes' => $aisShipTypes,
        ]);
    }
    
    #[Route('/portscompatibles', name:'portscompatibles')]
    public function portsCompatibles(ManagerRegistry $doctrine, Request $request, AisShipTypeRepository $repo): Response {
        $aisShipType = $repo->find($request->get('id'));
        $portsCompatibles = $doctrine->getRepository(Port::class);
        $tousPort = $portsCompatibles->findAll();
        //$paysDuPort = $portsCompatibles->findNomPays();
        return $this->render('aisshiptype/portscompatibles.html.twig', [
            'aisShipType' => $aisShipType,
            'tousPort' => $tousPort,
        ]);
    }
}
