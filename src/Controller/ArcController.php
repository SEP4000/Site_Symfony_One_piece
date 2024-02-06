<?php

namespace App\Controller;

use App\Entity\Arc;
use App\Entity\Comment;
use App\Form\ArcFormType;
use App\Form\CommentType;
use App\Repository\ArcRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/arc', name: 'arc_')] 
class ArcController extends AbstractController
{
    #[Route('/', name: 'app_arc_index')]
    public function index(Request $request ,ArcRepository $arcRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $arcRepository->paginationQuery(),
            $request->get('page', 1),
            6
        );

        return $this->render('arc/index_arc.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/ajout', name: 'add_arc', methods: ['GET', 'POST'])]
    public function add(Request $request, ArcRepository $arcRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $arc = new Arc();
        $Arcform = $this->createForm(ArcFormType::class, $arc);
        $Arcform->handleRequest($request);

        if($Arcform->isSubmitted() && $Arcform->isValid()){
            $arcRepository->save($arc, true);
            $this->addFlash('success', 'L\'arc a été ajouté avec succès');
            return $this->redirectToRoute('arc_app_arc_index');
        }

        return $this->render('arc/add_arc.html.twig', [
            'Arcform' => $Arcform->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit_arc', methods: ['GET', 'POST'])]
    public function edit(Arc $arc, Request $request, ArcRepository $arcRepository): Response
    {
        $this->denyAccessUnlessGranted('ARC_EDIT', $arc);

        $Arcform = $this->createForm(ArcFormType::class, $arc);
        $Arcform->handleRequest($request);

        if($Arcform->isSubmitted() && $Arcform->isValid()){
            $arcRepository->save($arc, true);
            $this->addFlash('success', 'L\'arc a été modifié avec succès');
            return $this->redirectToRoute('arc_app_arc_index');
        }
        return $this->render('arc/edit_arc.html.twig', [
            'Arcform' => $Arcform->createView(),
            'arc' => $arc
        ]);
    }

    #[Route('/suppresion/{id}', name: 'delete_arc')]
    public function delete(ManagerRegistry $doctrine,  Arc $arc): Response
    {
        $this->denyAccessUnlessGranted('ARC_DELETE', $arc);
        if($arc){
            $entityManager = $doctrine->getManager();
            $entityManager->remove($arc);
            $entityManager->flush();
            $this->addFlash('success', 'L\'arc a été suprimé avec succès');
        }
        return $this->redirectToRoute('arc_app_arc_index');
    }

    #[Route('/{nom_a}', name: 'details', methods: ['GET', 'POST'])]
    public function details(Arc $arc, ArcRepository $arcRepository, Request $request, EntityManagerInterface $entityManager, CommentRepository $commentRepository, $nom_a): Response
    {
        $arcsId = $arcRepository->findOneBy(['nom_a' => $nom_a]);

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $utilisateur = $this->getUser();
            $comment->setAuthor($utilisateur);
            $comment->setArcs($arcsId);
            $comment->setCreatedAt(new \DateTimeImmutable);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a été envoyé');
        }
        return $this->render('arc/details_arc.html.twig',[
            'arc' => $arc,
            'commentForm' => $commentForm->createView(),
            'comments' => $commentRepository->findBy(['arcs' => $arcsId])
        ]);
    }
}