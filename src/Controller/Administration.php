<?php

namespace App\Controller;


use App\Repository\ArcRepository;
use App\Repository\PersonnageRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class Administration extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('administration/administration_index.html.twig');
    }

    #[Route('/arc', name: 'arc_index')]
    public function index2(ArcRepository $arcRepository): Response
    {

        return $this->render('administration/administration_index_arc.html.twig', [
            'arcs' => $arcRepository->findBy([], 
            ['id' => 'ASC']),
        ]);
    }

    #[Route('/utilisateur', name: 'utilisateur_index')]
    public function index3(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('administration/administration_index_utilisateur.html.twig', [
            'utilisateurs' => $utilisateurRepository->findBy([],
            ['username' => 'ASC']),
        ]);
    }

    #[Route('/personnage', name: 'personnage_index')]
    public function index4(PersonnageRepository $personnageRepository): Response
    {

        return $this->render('administration/administration_index_personnage.html.twig', [
            'personnages' => $personnageRepository->findBy([], 
            ['id' => 'ASC']),
        ]);
    }
}