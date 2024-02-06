<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Form\PersonnageFormType;
use App\Repository\PersonnageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/personnage', name: 'personnage_')]
class PersonnageController extends AbstractController
{
    #[Route('/', name: 'app_personnage_index')]
    public function index(Request $request ,PersonnageRepository $personnageRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $personnageRepository->paginationQuery_2(),
            $request->get('page', 1),
            6
        );
        return $this->render('personnage/index_personnage.html.twig', [
            'pagination' => $pagination
        ]);
    }


    #[Route('/ajout', name: 'add_personnage', methods: ['GET', 'POST'])]
    public function add(Request $request, PersonnageRepository $personnageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $personnage = new Personnage();
        $Personnageform = $this->createForm(PersonnageFormType::class, $personnage);
        $Personnageform->handleRequest($request);

        if($Personnageform->isSubmitted() && $Personnageform->isValid()){
            $personnageRepository->save($personnage, true);
            $this->addFlash('success', 'Le personnage a été ajouté avec succès');
            return $this->redirectToRoute('personnage_app_personnage_index');
        }

        return $this->render('personnage/add_personnage.html.twig', [
            'Personnageform' => $Personnageform->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit_personnage', methods: ['GET', 'POST'])]
    public function edit(Personnage $personnage, Request $request, PersonnageRepository $personnageRepository): Response
    {
        $this->denyAccessUnlessGranted('PERSONNAGE_EDIT', $personnage);

        $Personnageform = $this->createForm(PersonnageFormType::class, $personnage);
        $Personnageform->handleRequest($request);

        if($Personnageform->isSubmitted() && $Personnageform->isValid()){
            $personnageRepository->save($personnage, true);
            $this->addFlash('success', 'Le personnage a été modifié avec succès');
            return $this->redirectToRoute('personnage_app_personnage_index');
        }
        return $this->render('personnage/edit_personnage.html.twig', [
            'Personnageform' => $Personnageform->createView(),
            'personnage' => $personnage
        ]);
    }

    #[Route('/suppresion/{id}', name: 'delete_personnage')]
    public function delete(ManagerRegistry $doctrine, Personnage $personnage): Response
    {
        $this->denyAccessUnlessGranted('PERSONNAGE_DELETE', $personnage);
        if($personnage){
            $entityManager = $doctrine->getManager();
            $entityManager->remove($personnage);
            $entityManager->flush();
            $this->addFlash('success', 'Le personnage a été suprimé avec succès');
        }
        return $this->redirectToRoute('personnage_app_personnage_index');
    }

    #[Route('/{prenom_p}', name: 'details', methods: ['GET', 'POST'])]
    public function details(Personnage $personnage, PersonnageRepository $personnageRepository, Request $request, EntityManagerInterface $entityManager, CommentRepository $commentRepository,  $prenom_p): Response
    {
        $personnageId = $personnageRepository->findOneBy(['prenom_p'=> $prenom_p]);

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $utilisateur = $this->getUser();
            $comment->setAuthor($utilisateur);
            $comment->setPersonnages($personnageId);
            $comment->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a été envoyé');
        }
        return $this->render('personnage/details_personnage.html.twig',[
            'personnage' => $personnage,
            'commentForm' => $commentForm->createView(),
            'comments' => $commentRepository->findBy(['personnages' => $personnageId])
        ]);
    }
}