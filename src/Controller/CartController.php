<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly PanierRepository $panierRepo,
        private readonly ProduitRepository $produitRepo,
        private readonly UserRepository $userRepo,
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request): JsonResponse
    {
        $user = $this->getCartUser();
        if (!$user) {
            return new JsonResponse(['status' => 'error', 'message' => 'Utilisateur non trouvé.'], 404);
        }

        $produit = $this->produitRepo->find($id);
        if (!$produit) {
            return new JsonResponse(['status' => 'error', 'message' => 'Produit introuvable.'], 404);
        }

        $existing = $this->panierRepo->findOneBy(['user' => $user, 'produit' => $produit]);
        $qty = max(1, (int) $request->get('qty', 1));

        if ($existing) {
            $existing->setQuantite($existing->getQuantite() + $qty);
        } else {
            $panier = new Panier();
            $panier->setUser($user);
            $panier->setProduit($produit);
            $panier->setQuantite($qty);
            $this->em->persist($panier);
        }

        $this->em->flush();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Produit ajouté !'
        ]);
    }

    #[Route('/remove/{id}', name: 'cart_remove', methods: ['POST', 'GET'])]
    public function remove(int $id, Request $request): Response
    {
        $user = $this->getCartUser();
        $row = $this->panierRepo->find($id);

        if ($row && $row->getUser()?->getId() === $user?->getId()) {
            $this->em->remove($row);
            $this->em->flush();
            
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['status' => 'success', 'message' => 'Article supprimé.']);
            }
            $this->addFlash('success', 'Article supprimé du panier.');
        } else {
            $message = "Impossible de supprimer cet élément.";
            
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['status' => 'error', 'message' => $message], 400);
            }
            $this->addFlash('danger', $message);
        }

        return $this->redirectToRoute('app_service');
    }

    #[Route('/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(int $id, Request $request): RedirectResponse
    {
        $user = $this->getCartUser();
        $row = $this->panierRepo->find($id);

        if (!$row || $row->getUser()?->getId() !== $user?->getId()) {
            $this->addFlash('danger', 'Ligne du panier introuvable.');
            return $this->redirectToRoute('app_service');
        }

        $qty = max(1, (int) $request->request->get('quantite', 1));
        $row->setQuantite($qty);
        $this->em->flush();

        $this->addFlash('success', 'Quantité mise à jour.');
        return $this->redirectToRoute('app_service');
    }

    #[Route('/fragment', name: 'cart_fragment', methods: ['GET'])]
    public function fragment(): Response
    {
        $user = $this->getCartUser();
        $items = $user ? $this->panierRepo->findByUser($user) : [];

        $total = array_reduce($items, fn($sum, $item) => $sum + ($item->getProduit()->getPrix() * $item->getQuantite()), 0);

        return $this->render('cart/_cart_items.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    private function getCartUser(): ?User
    {
        // PRO: Try to get authenticated user first
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

        // FALLBACK: For development if no auth is present (Legacy support)
        return $this->userRepo->find(1);
    }
}
