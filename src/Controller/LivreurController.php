<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\LivreurType;
use App\Repository\LivreurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreurController extends AbstractController
{
    #[Route('/livreur', name: 'app_livreur')]
    public function index(): Response
    {
        return $this->render('livreur/index.html.twig', [
            'controller_name' => 'LivreurController',
        ]);
    }
    #[Route('addlivreur',name: 'add_livreur')]
    public function addlivreur(Request $request,ManagerRegistry $doctrine):Response
    {
        $livreur=new Livreur();
        $form=$this->createForm(LivreurType::class, $livreur);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $em=$doctrine->getManager();
            $em->persist($livreur);
            $em->flush();

            return $this->redirectToRoute("list_livreur");
        }

        return $this->render('livreur/add.html.twig',['form'=>$form->createView()]);
    }

    #[Route('listlivreur', name: 'list_livreur')]
    public function listlivreur(LivreurRepository $repository):Response
    {
        $livreur=$repository->findAll();
        return $this->render("livreur/list.html.twig",array("tablelivreur"=>$livreur));
    }
    #[Route('removelivreur/{id}',name: 'remove_livreur')]
    public function removelivreur($id,LivreurRepository $repository):Response
    {
        $livreur=$repository->removeById($id);
        return $this->redirectToRoute("list_livreur");
    }

    #[Route('updatelivreur/{id}',name: 'update_livreur')]
    public function updatelivreur($id,LivreurRepository $repository,Request $request,ManagerRegistry $doctrine):Response
    {
        $livreur=$repository->find($id);
        $form=$this->createForm(LivreurType::class,$livreur);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("list_livreur");
        }

        return $this->render("livreur/update.html.twig", ['form' => $form->createView()]);

    }
}
