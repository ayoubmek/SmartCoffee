<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface; 
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/offer')]
final class OfferController extends AbstractController
{
   #[Route( name: 'app_offer_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        if (!$session->get('logged_in')) {
            return $this->redirectToRoute('app_login');
        }

        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);

        $offers = $em->getRepository(Offer::class)->findAll();

        return $this->render('offer/index.html.twig', [
            'offers'    => $offers,
            'form'      => $form->createView(),
        ]);
    }

/* ---------- CREATE ---------- */
#[Route('/offer/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $offer = new Offer();
    $form = $this->createForm(OfferType::class, $offer);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form->get('imageFile')->getData();

        if ($file) {
            // Keep the original filename (with extension)
            $originalFilename = $file->getClientOriginalName();

            // Define target directory
            $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch';
            $targetPath = $targetDir . '/' . $originalFilename;

            // Move the file (overwrite if it exists)
            $file->move($targetDir, $originalFilename);

            // Save relative path in DB
            $offer->setImage('assets/media/ch/' . $originalFilename);
        }

        $em->persist($offer);
        $em->flush();

            return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
    }
 
}


    #[Route('/{id}', name: 'app_offer_show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offer_edit', methods: ['POST'])]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('imageFile')->getData();

            if ($file) {
                // Keep the original filename (with extension)
                $originalFilename = $file->getClientOriginalName();
                $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch';

                // Move the file (overwrite if it exists)
                $file->move($targetDir, $originalFilename);

                // Save relative path in DB
                $offer->setImage('assets/media/ch/' . $originalFilename);
            }

            $em->flush();
                return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
        }
        
            return $this->redirectToRoute('app_offer_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit-form', name: 'app_offer_edit_form', methods: ['GET'])]
    public function editForm(Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer, [
            'action' => $this->generateUrl('app_offer_edit', ['id' => $offer->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('offer/_form_edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }


#[Route('/{id}/delete', name: 'app_offer_delete', methods: ['GET'])]
public function delete(Offer $offer, EntityManagerInterface $em, Request $request): Response
{
    $em->remove($offer);
    $em->flush();
 
    $referer = $request->headers->get('referer');
 
    return $this->redirect($referer ?? $this->generateUrl('app_offer_index'));
}

  

private function handleImageUpload(?UploadedFile $file, Offer $offer, SluggerInterface $slugger): void
{
    if (!$file) {
        return;
    }

    // Keep original filename (with extension)
    $originalFilename = $file->getClientOriginalName();

    $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch';
    $targetPath = $targetDir . '/' . $originalFilename;

    // If file does not exist, move it
    if (!file_exists($targetPath)) {
        $file->move($targetDir, $originalFilename);
    }

    // Save relative path in DB
    $offer->setImage('assets/media/ch/' . $originalFilename);
}


}
