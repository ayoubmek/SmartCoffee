<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        // Get statistics
        $totalProducts = $em->getRepository(Produit::class)->count([]);
        $totalCategories = $em->getRepository(Categorie::class)->count([]);
        $totalUsers = $em->getRepository(User::class)->count([]);
        $totalOrders = $em->getRepository(Commande::class)->count([]);
        $totalOffers = $em->getRepository(Offer::class)->count([]);
        
        // Get recent orders
        $recentOrders = $em->getRepository(Commande::class)->findBy([], ['id' => 'DESC'], 5);
        
        // Get recent products
        $recentProducts = $em->getRepository(Produit::class)->findBy([], ['id' => 'DESC'], 5);
        
        // Calculate total revenue
        $totalRevenue = 0;
        $orders = $em->getRepository(Commande::class)->findAll();
        foreach ($orders as $order) {
            $totalRevenue += $order->getTotal();
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalOffers' => $totalOffers,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'recentProducts' => $recentProducts,
        ]);
    }
}
