<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NavireRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NavireType;

#[Route('/navire', name: 'navire')]
class NavireController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('navire/index.html.twig', [
            'controller_name' => 'NavireController',
        ]);
    }
    
    #[Route('/editer/{id}', name:'editer')]
    public function editer(int $id, Request $request, NavireRepository $repoNavire, EntityManagerInterface $em) : Response {
        $navire = $repoNavire->find($id);
        
        $form = $this->createForm(NavireType::class, $navire);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $navire = $form->getData();
        }
    }
}
