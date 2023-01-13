<?php

namespace App\Admin\Controller;

use App\Admin\Controller\Base\BaseAdminCrudController;
use App\Admin\Interface\AdminControllerInterface;
use App\Entity\Page;
use App\Form\PageType;
use App\Form\NewPageType;
use App\Repository\PageRepository;
use App\Table\TableGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class AdminPageController extends BaseAdminCrudController implements AdminControllerInterface
{

    public static function getAdminName(): string
    {
        return 'Strony';
    }

    #[Route('/', name: 'admin_page_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository, TableGenerator $tableGenerator): Response
    {
        $table = $tableGenerator
            ->addEntities($pageRepository->findAll(), ['title', 'category', 'author', 'createdAt', 'published', 'promoted'])
            ->addOptionsColumn()
            ->sortBy('createdAt', 'DESC')
//            ->addIncrementalColumn()
            ->build();

        return $this->renderCrudIndex(
            className: Page::class,
            formType: NewPageType::class,
            table: $table
        );
    }

    #[Route('/new', name: 'admin_page_new', methods: ['POST'])]
    public function new(): Response
    {
        return $this->processCrudNew(
            className: Page::class,
            formType: NewPageType::class,
        );
    }

    #[Route('/{id}/details', name: 'admin_page_details', methods: ['GET'])]
    public function details(Page $page, TableGenerator $tableGenerator): Response
    {
        $table = $tableGenerator
            ->addEntities([$page])
            ->setVertical()
            ->build();

        return $this->renderCrudDetails(
            entity: $page,
            table: $table
        );
    }

    #[Route('/{id}/edit', name: 'admin_page_edit', methods: ['GET', 'POST'])]
    public function edit(Page $page): Response
    {
        return $this->renderCrudEdit(
            entity: $page,
            formType: PageType::class,
        );
    }

    #[Route('/{id}', name: 'admin_page_delete', methods: ['POST'])]
    public function delete(Page $page): Response
    {
        return $this->processCrudDelete(
            entity: $page,
        );
    }
}