<?php
declare (strict_types=1);

namespace App\Api\Controller;

use App\Repository\PageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api', name: "api_")]
class PagesController extends AbstractFOSRestController
{
    #[Rest\Get('/pages', name: "pages_index")]
    public function getPages(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findAll();

        $data = [];

        foreach ($pages as $page) {
            $data[] = [
                'id' => $page->getId(),
                'author_id' => $page->getAuthor()->getId(),
                'category_id' => $page->getCategory() ? $page->getCategory()->getId() : null,
                'title' => $page->getTitle(),
                'slug' => $page->getSlug(),
                'tags' => implode(',', $page->getTags()),
                'promoted' => $page->isPromoted(),
                'published' => $page->isPublished(),
                'created_at' => $page->getCreatedAt(),
                'updated_at' => $page->getCreatedAt(),
            ];
        }

        return $this->json($data);
    }
}