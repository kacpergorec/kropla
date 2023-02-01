<?php
declare (strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Interface\AdminControllerInterface;
use App\Admin\Metadata\AdminMetadata;
use DirectoryIterator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/media')]
class AdminMediaController extends AbstractController implements AdminControllerInterface
{

    protected const MEDIA_PATH = '/public/uploads';

    public static function getAdminMetadata(): AdminMetadata
    {
        return new AdminMetadata(
            label: 'Media',
            order: 5,
            iconClass: 'ph-image-light'
        );
    }


    #[Route("/", name: "admin_media_index", methods: ['GET'])]
    public function index(Request $request): Response
    {
        $directory = $request->query->get('dir');

        $uploadPath = $this->getParameter('kernel.project_dir') . '/public/uploads';

        if ($directory) {
            $uploadPath .= '/' . $directory;

            //Removes trailing slashes
            $currentDirectory = preg_replace('/\/+/', '/', $directory . '/');
        }

        $filesystem = new Filesystem();
        if (!$filesystem->exists($uploadPath)) {
            throw $this->createNotFoundException(sprintf('The directory %s does not exist.', $uploadPath));
        }

        $finder = (new Finder())
            ->in($uploadPath)
            ->depth(0)
            ->ignoreDotFiles(true);


        return $this->render('admin/media/index.html.twig', [
            'currentDirectory' => $currentDirectory ?? null,
            'finder' => $finder,
        ]);
    }
}