<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/categorie')]
final class CategorieController extends AbstractController
{
#[Route( name: 'app_categorie_index', methods: ['GET'])]
public function index(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
{
    // 1️⃣ Protect page: check login
    if (!$session->get('logged_in')) {
        return $this->redirectToRoute('app_login');
    }

    // 2️⃣ Your existing logic
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);

    $categories = $em->getRepository(Categorie::class)->findAll();
    $editForms = [];
    foreach ($categories as $category) {
        $editForms[$category->getId()] = $this->createForm(CategorieType::class, $category)->createView();
    }

    // 3️⃣ Render template
    $response = $this->render('categorie/index.html.twig', [
        'categories' => $categories,
        'form'       => $form->createView(),
        'editForms'  => $editForms,
    ]);

    // 4️⃣ Prevent browser caching (Back button issue)
    $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');

    return $response;
}



    /* ---------- CREATE ---------- */
    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('iconeFile')->getData();

            if ($file) {
                // Use the real original file name
                $originalName = $file->getClientOriginalName();

                // Define the target directory
                $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch';

                // Move the file using its real name
                $file->move($targetDir, $originalName);

                // Save the path in the database
                $categorie->setIcone('assets/media/ch/' . $originalName);
            }

            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }



   #[Route('/{id}/edit', name: 'app_categorie_edit', methods: ['POST'])]
public function edit(Request $request, Categorie $categorie, EntityManagerInterface $em): Response
{
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form->get('iconeFile')->getData();

        if ($file) {
            // Keep the original file name
            $originalName = $file->getClientOriginalName();
            $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch';

            // Move the file (this will overwrite if the same name exists)
            $file->move($targetDir, $originalName);

            // Update entity path
            $categorie->setIcone('assets/media/ch/' . $originalName);
        }

        $em->flush();

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
}



#[Route('/{id}/delete', name: 'app_categorie_delete', methods: ['GET'])]
public function delete(Categorie $categorie, EntityManagerInterface $em, Request $request): Response
{
    $em->remove($categorie);
    $em->flush();
 
    $referer = $request->headers->get('referer');
 
    return $this->redirect($referer ?? $this->generateUrl('app_categorie_index'));
}

private function handleIconeUpload(?UploadedFile $file, Categorie $categorie): void
{
    if (!$file) {
        return;
    } 
    $originalName = $file->getClientOriginalName(); 
    $targetDir = $this->getParameter('kernel.project_dir') . '/public/assets/media/ch'; 
    $file->move($targetDir, $originalName);
 
    $categorie->setIcone('assets/media/ch/' . $originalName);
}
}
