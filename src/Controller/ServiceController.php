<?php
namespace App\Controller;
use App\Entity\Payment; 
use App\Entity\Produit; 
use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\HistoryRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{

    #[Route('/service', name: 'app_service')]
public function index1(
    CategorieRepository $categorieRepository,
    ProduitRepository $produitRepository,
    OfferRepository $offerRepository
): Response
{ 
    // Get all offers
    $offers = $offerRepository->findAll();

    // Get all categories
    $categories = $categorieRepository->findAll();

    // Get all products ordered by position ASC
    $produits = $produitRepository->findBy([], ['position' => 'ASC']);

    return $this->render('service/service.html.twig', [
        'categories' => $categories,
        'produits' => $produits,
        'offers' => $offers,
    ]);
}


    #[Route('/offers', name: 'app_offers')]
public function index(EntityManagerInterface $em): Response
{
    $offers = $em->getRepository(Offer::class)->findAll();

    return $this->render('offer/index.html.twig', [
        'offers' => $offers,
    ]);
}


    #[Route('/produit/{id}', name: 'app_produit_details')]
public function details(Produit $produit): Response
{
    return $this->render('produit/details.html.twig', [
        'produit' => $produit,
    ]);
}


}