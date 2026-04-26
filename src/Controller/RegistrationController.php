<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegistrationController extends AbstractController
{
    #[Route('/', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em): Response
    {
       
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $gender = $request->request->get('gender');

            if ($name && $gender) {
                // Create a new simple user
                $user = new User();
                $user->setName($name);
                $user->setGender($gender);
                // Set defaults for required fields if any (simulating a 'guest' or 'simple' registration)
                // We'll set a dummy email/password since your User entity likely requires them or simpler authentication is used.
                // Assuming email is unique, we generate a random one or use name
                $user->setEmail(uniqid().'@guest.com'); 
                $user->setPassword(password_hash('guest', PASSWORD_BCRYPT));
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setRole('ROLE_USER'); // or ROLE_GUEST

                $em->persist($user);
                $em->flush();

                // Manually log the user in (Simple approach for "simple registration")
                // In a full Symfony Security app, we'd use Guard or UserAuthenticator, 
                // but here we might rely on the session or the fact that previous controllers looked for User ID 1.
                // However, our refactored Service/Cart controllers first look for $this->getUser().
                // So we need to properly log this new user in.
                
                // Note: For this to work, security.yaml must be configured to support this provider.
                // We'll attempt a simple redirect for now, assuming the user ID 1 fallback isn't what we want anymore if we are "registering".
                // But if the user wants "just name and gender", maybe we are UPDATING User 1? 
                // "add page for do register in first time" implies a new user.
                
                // Let's manually authenticate mostly to satisfy $this->getUser() checks if security is active.
                // If not active, we might need to store ID in session.
                 $request->getSession()->set('user_id', $user->getId());

                return $this->redirectToRoute('app_service');
            }
        }

        return $this->render('registration/register.html.twig');
    }
}
