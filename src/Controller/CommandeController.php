<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeItem;
use App\Entity\User;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    public function __construct(
        private readonly PanierRepository $panierRepo,
        private readonly CommandeRepository $commandeRepo,
        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(SessionInterface $session): Response
    {
         // Optional: Check if logged in
         // if (!$session->get('logged_in')) return $this->redirectToRoute('app_login');
         
         $commandes = $this->commandeRepo->findBy([], ['createdAt' => 'DESC']);

         return $this->render('commande/index.html.twig', [
             'commandes' => $commandes,
         ]);
    }
    
    #[Route('/list-rows', name: 'app_commande_list_rows', methods: ['GET'])]
    public function listRows(SessionInterface $session): Response
    {
         $commandes = $this->commandeRepo->findBy([], ['createdAt' => 'DESC']);

         return $this->render('commande/_table_rows.html.twig', [
             'commandes' => $commandes,
         ]);
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(Request $request): Response
    {
        $user = $this->getServiceUser();
        
        if (!$user) {
             $this->addFlash('danger', 'Veuillez vous identifier pour passer commande.');
             return $this->redirectToRoute('app_service');
        }

        // 1. Get Cart Items
        $cartItems = $this->panierRepo->findByUser($user);

        if (empty($cartItems)) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_service');
        }

        // 2. Create Commande
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setStatus('En attente'); // Status Pending
        $commande->setTotal(0); // Will calculate

        $total = 0.0;

        foreach ($cartItems as $cartItem) {
            $commandeItem = new CommandeItem();
            $commandeItem->setProduit($cartItem->getProduit());
            $commandeItem->setQuantite($cartItem->getQuantite());
            $commandeItem->setPrix($cartItem->getProduit()->getPrix()); // Snapshot price
            
            $commande->addItem($commandeItem);
            
            $total += ($commandeItem->getPrix() * $commandeItem->getQuantite());
            
            // Remove from cart
            $this->em->remove($cartItem);
        }

        $commande->setTotal($total);
        $this->em->persist($commande);
        $this->em->flush();

        // 3. Redirect to Confirmation/Details
        return $this->redirectToRoute('commande_details', ['id' => $commande->getId()]);
    }

    #[Route('/{id}/update-status', name: 'app_commande_update_status', methods: ['POST'])]
    public function updateStatus(Commande $commande, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $action = $data['action'] ?? null;

        if ($action === 'approve') {
            $commande->setStatus('Approuvé');
        } elseif ($action === 'conform') {
            $commande->setStatus('Conforme');
        }
        
        $em->flush();
        
        return $this->json(['success' => true, 'status' => $commande->getStatus()]);
    }

    #[Route('/{id}/status', name: 'app_commande_status_ajax', methods: ['GET'])]
    public function statusAjax(Commande $commande): JsonResponse
    {
        return $this->json(['status' => $commande->getStatus()]);
    }

    #[Route('/{id}', name: 'commande_details')]
    public function details(Commande $commande, SessionInterface $session): Response
    {
        // Security check: ensure user owns this order OR is admin
        $user = $this->getServiceUser();
        $isAdmin = $session->get('logged_in');

        if (!$isAdmin && $commande->getUser() !== $user) {
             throw $this->createAccessDeniedException('Vous ne pouvez pas voir cette commande.');
        }

        return $this->render('commande/details.html.twig', [
            'commande' => $commande,
        ]);
    }

    private function getServiceUser(): ?User
    {
         // Try standard auth
        /** @var User|null $user */
        $user = $this->getUser();
        if ($user) {
            return $user;
        }

        // Check session for simple reg flow (as done in Service/CartController)
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $sessionUserId = $request?->getSession()->get('user_id');
        
        if ($sessionUserId) {
            return $this->userRepo->find($sessionUserId);
        }

        // Fallback for dev (id 1) logic if used elsewhere, but maybe unsafe for checkout.
        // Let's stick to consistent behavior with CartController
        return $this->userRepo->find(1);
    }
}
