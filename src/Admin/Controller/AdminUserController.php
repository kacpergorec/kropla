<?php

namespace App\Admin\Controller;

use App\Admin\Controller\Base\BaseAdminCrudController;
use App\Admin\Interface\AdminControllerInterface;
use App\Admin\Metadata\AdminMetadata;
use App\Entity\User;
use App\Form\Entity\User\NewUserType;
use App\Form\Entity\User\UserType;
use App\Repository\UserRepository;
use App\Table\TableGenerator;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/user')]
class AdminUserController extends BaseAdminCrudController implements AdminControllerInterface
{
    public static function getAdminMetadata(): AdminMetadata
    {
        return new AdminMetadata(
            'Użytkownicy',
            iconClass: 'ph-users-light',
            description: 'admin.user.description'
        );
    }

    #[Route('/', name: 'admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, TableGenerator $tableGenerator)
    {
        $table = $tableGenerator
            ->addEntities($userRepository->findAll(), ['firstName', 'lastName', 'email'])
            ->addOptionsColumn()
            //            ->sortBy('createdAt', 'DESC')
            //            ->addIncrementalColumn()
            ->build();

        return $this->renderCrudIndex(
            className: User::class,
            formType: NewUserType::class,
            table: $table
        );
    }

    #[Route('/new', name: 'admin_user_new', methods: ['POST'])]
    public function new()
    {
        return $this->processCrudNew(
            className: User::class,
            formType: NewUserType::class,
        );
    }

    #[Route('/{id}/details', name: 'admin_user_details', methods: ['GET'])]
    public function details(User $user, TableGenerator $tableGenerator)
    {
        $table = $tableGenerator
            ->addEntities([$user])
            ->setVertical()
            ->build();

        return $this->renderCrudDetails(
            entity: $user,
            table: $table
        );
    }

    #[Route('/{id}/edit', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(User $user)
    {
        return $this->renderCrudEdit(
            entity: $user,
            formType: UserType::class,
        );
    }

    #[Route('/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(User $user)
    {
        return $this->processCrudDelete(
            entity: $user,
        );
    }
}
