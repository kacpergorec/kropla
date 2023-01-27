<?php
declare (strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Interface\AdminControllerInterface;
use App\Admin\Metadata\AdminMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/media')]
class AdminMediaController extends AbstractController implements AdminControllerInterface
{
    public static function getAdminMetadata(): AdminMetadata
    {
        return new AdminMetadata(
            label: 'Media',
            order: 5,
            iconClass: 'ph-image-light'
        );
    }

    #[Route("/", name: "admin_media_index")]
    public function index(): Response
    {
        return $this->render('admin/media/index.html.twig');
    }
}