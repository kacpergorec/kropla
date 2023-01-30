<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/{slug}', name: 'app_page', priority: -10)]
    public function index(Page $page): Response
    {
        if (!$page->isPublished()){
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
