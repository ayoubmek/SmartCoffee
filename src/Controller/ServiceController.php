<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Produit;
use App\Entity\User;
use App\Repository\CategorieRepository;
use App\Repository\OfferRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    public function __construct(
        private readonly CategorieRepository $categorieRepo,
        private readonly OfferRepository $offerRepo,
        private readonly PanierRepository $panierRepo,
        private readonly UserRepository $userRepo
    ) {
    }

    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        $user = $this->getServiceUser();

        // Fetch offers
        $offers = $this->offerRepo->findAll();

        // Optimized Category Fetch with eager loading of products
        $categories = $this->categorieRepo->createQueryBuilder('c')
            ->leftJoin('c.produits', 'p')
            ->addSelect('p')
            ->orderBy('c.id', 'ASC')
            ->addOrderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult();

        // Fetch Cart Items
        $items = $user ? $this->panierRepo->findByUser($user) : [];

        // Calculate Total
        $total = array_reduce($items, fn($sum, $item) => $sum + ($item->getProduit()->getPrix() * $item->getQuantite()), 0);

        return $this->render('service/service.html.twig', [
            'categories' => $categories,
            'offers' => $offers,
            'items' => $items,
            'total' => $total,
            'user' => $user, // Pass the user to the template
        ]);
    }

    #[Route('/offers', name: 'app_offers')]
    public function offers(): Response
    {
        $offers = $this->offerRepo->findAll();

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/prod/{id}', name: 'app_produit_details')]
    public function details(Produit $produit): Response
    {
        return $this->render('produit/details.html.twig', [
            'produit' => $produit,
        ]);
    }

    private function getServiceUser(): ?User
    {
        /** @var User|null $user */
        $user = $this->getUser();
        if ($user) {
            return $user;
        }

        // Check session for simple reg flow
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $sessionUserId = $request?->getSession()->get('user_id');
        
        if ($sessionUserId) {
            return $this->userRepo->find($sessionUserId);
        }

        return $this->userRepo->find(1);
    }
}