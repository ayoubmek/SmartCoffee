<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produit')]
class AdminProduitController extends AbstractController
{
    #[Route('/', name: 'admin_produit_index')]
    public function index(ProduitRepository $repository): Response
    {
        $produits = $repository->findBy([], ['position' => 'ASC', 'id' => 'DESC']);
        
        return $this->render('admin/produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'admin_produit_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $produit = new Produit();
        
        if ($request->isMethod('POST')) {
            $produit->setNom($request->request->get('nom'));
            $produit->setDescription($request->request->get('description'));
            $produit->setPrix((float) $request->request->get('prix'));
            $produit->setPrixAncien($request->request->get('prixAncien') ? (float) $request->request->get('prixAncien') : null);
            $produit->setReduction($request->request->get('reduction') ? (int) $request->request->get('reduction') : null);
            $produit->setImage($request->request->get('image'));
            $produit->setPosition($request->request->get('position') ? (int) $request->request->get('position') : null);
            
            $categorieId = $request->request->get('categorie');
            if ($categorieId) {
                $categorie = $em->getRepository(Categorie::class)->find($categorieId);
                $produit->setCategorie($categorie);
            }
            
            $em->persist($produit);
            $em->flush();
            
            $this->addFlash('success', 'Produit créé avec succès!');
            return $this->redirectToRoute('admin_produit_index');
        }
        
        $categories = $em->getRepository(Categorie::class)->findAll();
        
        return $this->render('admin/produit/new.html.twig', [
            'produit' => $produit,
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_produit_edit')]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $produit->setNom($request->request->get('nom'));
            $produit->setDescription($request->request->get('description'));
            $produit->setPrix((float) $request->request->get('prix'));
            $produit->setPrixAncien($request->request->get('prixAncien') ? (float) $request->request->get('prixAncien') : null);
            $produit->setReduction($request->request->get('reduction') ? (int) $request->request->get('reduction') : null);
            $produit->setImage($request->request->get('image'));
            $produit->setPosition($request->request->get('position') ? (int) $request->request->get('position') : null);
            
            $categorieId = $request->request->get('categorie');
            if ($categorieId) {
                $categorie = $em->getRepository(Categorie::class)->find($categorieId);
                $produit->setCategorie($categorie);
            }
            
            $em->flush();
            
            $this->addFlash('success', 'Produit modifié avec succès!');
            return $this->redirectToRoute('admin_produit_index');
        }
        
        $categories = $em->getRepository(Categorie::class)->findAll();
        
        return $this->render('admin/produit/edit.html.twig', [
            'produit' => $produit,
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_produit_delete', methods: ['POST'])]
    public function delete(Produit $produit, EntityManagerInterface $em): Response
    {
        $em->remove($produit);
        $em->flush();
        
        $this->addFlash('success', 'Produit supprimé avec succès!');
        return $this->redirectToRoute('admin_produit_index');
    }
}
