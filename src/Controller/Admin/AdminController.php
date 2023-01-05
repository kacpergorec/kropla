<?php

namespace App\Controller\Admin;

use App\Menu\AdminMenuGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_panel')]
    public function index(AdminMenuGenerator $menuGenerator): Response
    {
        return $this->render('admin/panel.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/login', name: 'admin_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {

//         if ($this->getUser()) {
//             return $this->redirectToRoute('admin_panel');
//         }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/admin/logout', name: 'admin_logout')]
    public function logout(): void
    {
    }
}
