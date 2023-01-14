<?php

namespace App\Admin\Controller;

use App\Admin\Controller\Base\BaseAdminCrudController;
use App\Admin\Metadata\AdminMetadata;
use App\Entity\Post;
use App\Admin\Interface\AdminControllerInterface;
use App\Repository\PostRepository;
use App\Table\TableGenerator;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Form\NewPostType;


#[Route('/admin/post')]
class AdminPostController extends BaseAdminCrudController implements AdminControllerInterface
{
    public static function getAdminMetadata(): AdminMetadata
    {
        return new AdminMetadata(
            'Blog',
            3,
            'ph-article-medium-light',
            'admin.post.description'
        );
    }

    #[Route('/', name: 'admin_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, TableGenerator $tableGenerator)
    {
                    $table = $tableGenerator
            ->addEntities($postRepository->findAll())
            ->addOptionsColumn()
            //            ->sortBy('createdAt', 'DESC')
            //            ->addIncrementalColumn()
            ->build();

            return $this->renderCrudIndex(
            className: Post::class,
            formType: NewPostType::class,
            table: $table
            );
            }

    #[Route('/new', name: 'admin_post_new', methods: ['POST'])]
    public function new()
    {
                    return $this->processCrudNew(
            className: Post::class,
            formType: NewPostType::class,
            );
            }

    #[Route('/{id}/details', name: 'admin_post_details', methods: ['GET'])]
    public function details(Post $post, TableGenerator $tableGenerator)
    {
                    $table = $tableGenerator
            ->addEntities([$post])
            ->setVertical()
            ->build();

            return $this->renderCrudDetails(
            entity: $post,
            table: $table
            );
            }

    #[Route('/{id}/edit', name: 'admin_post_edit', methods: ['GET', 'POST'])]
    public function edit(Post $post)
    {
                    return $this->renderCrudEdit(
            entity: $post,
            formType: PostType::class,
            );
            }

    #[Route('/{id}', name: 'admin_post_delete', methods: ['POST'])]
    public function delete(Post $post)
    {
                    return $this->processCrudDelete(
            entity: $post,
            );
            }
}
