<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use App\Repository\LivraisonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivraisonController extends AbstractController
{
    #[Route('/livraison', name: 'app_livraison')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'LivraisonController'
        ]);
    }
    #[Route('/addlivraison', name: 'add_livraison')]
    public function addLivraison(Request $request, ManagerRegistry $doctrine): Response
    {
        $livraison = new Livraison();
        $form=$this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($livraison);
            $em->flush();

            return $this->redirectToRoute("list_livraison");
        }

        return $this->render("livraison/add.html.twig",['form' => $form->createView()]);
    }

    #[Route('/listLivraison', name: 'list_livraison')]
    public function listLivraison(LivraisonRepository $repository): Response
    {
        $livraison =$repository->findAll();
        return $this->render("livraison/list.html.twig",array("tablelivraison"=>$livraison));
    }
    #[Route('/removelivraison/{id}', name: 'remove_livraison')]
    public function removeLivraison($id, LivraisonRepository $repository): Response
    {
        $livraison=$repository->removeById($id);
        return $this->redirectToRoute('list_livraison');
    }
    #[Route('/update-livraison/{id}', name: 'update_livraison')]
    public function updateLivraison($id, LivraisonRepository $repository, Request $request, ManagerRegistry $doctrine): Response
    {
        $livraison=$repository->find($id);
        $form = $this->createForm(LivraisonType::class,$livraison);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("list_livraison");
        }

        return $this->render("livraison/update.html.twig",['form' => $form->createView()]);
    }
}
