<?php

namespace App\Admin\Controller;

use App\Admin\Controller\Base\BaseAdminCrudController;
use App\Admin\Metadata\AdminMetadata;
use App\Entity\Category;
use App\Admin\Interface\AdminControllerInterface;
use App\Repository\CategoryRepository;
use App\Table\TableGenerator;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use App\Form\NewCategoryType;


#[Route('/admin/category')]
class AdminCategoryController extends BaseAdminCrudController implements AdminControllerInterface
{
    public static function getAdminMetadata(): AdminMetadata
    {
        return new AdminMetadata(
            'Kategorie',
            2,
            'ph-list-numbers-light',
            'admin.categories.description'
        );
    }

    #[Route('/', name: 'admin_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, TableGenerator $tableGenerator)
    {
        $table = $tableGenerator
            ->addEntities($categoryRepository->findAll(), ['Tytuł' => 'title', 'Strony' => 'pages'])
            ->addOptionsColumn()
            //            ->sortBy('createdAt', 'DESC')
            //            ->addIncrementalColumn()
            ->build();

        return $this->renderCrudIndex(
            className: Category::class,
            formType: NewCategoryType::class,
            table: $table
        );
    }

    #[Route('/new', name: 'admin_category_new', methods: ['POST'])]
    public function new()
    {
        return $this->processCrudNew(
            className: Category::class,
            formType: NewCategoryType::class,
        );
    }

    #[Route('/{id}/details', name: 'admin_category_details', methods: ['GET'])]
    public function details(Category $category, TableGenerator $tableGenerator)
    {
        $table = $tableGenerator
            ->addEntities([$category])
            ->setVertical()
            ->build();

        return $this->renderCrudDetails(
            entity: $category,
            table: $table
        );
    }

    #[Route('/{id}/edit', name: 'admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(Category $category)
    {
        return $this->renderCrudEdit(
            entity: $category,
            formType: CategoryType::class,
        );
    }

    #[Route('/{id}', name: 'admin_category_delete', methods: ['POST'])]
    public function delete(Category $category)
    {
        return $this->processCrudDelete(
            entity: $category,
        );
    }
}
