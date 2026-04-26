<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/offer')]
class AdminOfferController extends AbstractController
{
    #[Route('/', name: 'admin_offer_index')]
    public function index(OfferRepository $repository): Response
    {
        $offers = $repository->findAll();
        
        return $this->render('admin/offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/new', name: 'admin_offer_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $offer = new Offer();
            $offer->setImage($request->request->get('image'));
            
            $em->persist($offer);
            $em->flush();
            
            $this->addFlash('success', 'Offre créée avec succès!');
            return $this->redirectToRoute('admin_offer_index');
        }
        
        return $this->render('admin/offer/new.html.twig');
    }

    #[Route('/{id}/edit', name: 'admin_offer_edit')]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $offer->setImage($request->request->get('image'));
            
            $em->flush();
            
            $this->addFlash('success', 'Offre modifiée avec succès!');
            return $this->redirectToRoute('admin_offer_index');
        }
        
        return $this->render('admin/offer/edit.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_offer_delete', methods: ['POST'])]
    public function delete(Offer $offer, EntityManagerInterface $em): Response
    {
        $em->remove($offer);
        $em->flush();
        
        $this->addFlash('success', 'Offre supprimée avec succès!');
        return $this->redirectToRoute('admin_offer_index');
    }
}
