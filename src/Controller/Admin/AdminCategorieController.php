<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categorie')]
class AdminCategorieController extends AbstractController
{
    #[Route('/', name: 'admin_categorie_index')]
    public function index(CategorieRepository $repository): Response
    {
        $categories = $repository->findAll();
        
        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'admin_categorie_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $categorie = new Categorie();
            $categorie->setNom($request->request->get('nom'));
            $categorie->setDescription($request->request->get('description'));
            $categorie->setIcone($request->request->get('icone'));
            
            $em->persist($categorie);
            $em->flush();
            
            $this->addFlash('success', 'Catégorie créée avec succès!');
            return $this->redirectToRoute('admin_categorie_index');
        }
        
        return $this->render('admin/categorie/new.html.twig');
    }

    #[Route('/{id}/edit', name: 'admin_categorie_edit')]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $categorie->setNom($request->request->get('nom'));
            $categorie->setDescription($request->request->get('description'));
            $categorie->setIcone($request->request->get('icone'));
            
            $em->flush();
            
            $this->addFlash('success', 'Catégorie modifiée avec succès!');
            return $this->redirectToRoute('admin_categorie_index');
        }
        
        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_categorie_delete', methods: ['POST'])]
    public function delete(Categorie $categorie, EntityManagerInterface $em): Response
    {
        $em->remove($categorie);
        $em->flush();
        
        $this->addFlash('success', 'Catégorie supprimée avec succès!');
        return $this->redirectToRoute('admin_categorie_index');
    }
}
