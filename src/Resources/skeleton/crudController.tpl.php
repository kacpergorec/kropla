<?= "<?php\n" ?>

namespace <?= $controller['namespace'] ?>;

use App\Entity\<?=$entity?>;
use App\Controller\Admin\AdminControllerInterface;
use App\Repository\<?= $entity ?>Repository;
use App\Table\TableGenerator;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\<?=$entity?>Type;
use App\Form\New<?=$entity?>Type;


#[Route('/admin/<?= $entityLowercase ?>')]
class <?= $controller['className'] ?> extends BaseAdminCrudController implements AdminControllerInterface
{
    public static function getAdminName(): string
    {
        return '<?= $entity ?>';
    }

    #[Route('/', name: 'admin_<?= $entityLowercase ?>_index', methods: ['GET'])]
    public function index(<?= $entity ?>Repository $<?= $entityLowercase ?>Repository, TableGenerator $tableGenerator)
    {
        <?php if($controller['addMethodBody']):?>
            $table = $tableGenerator
            ->addEntities($<?= $entityLowercase ?>Repository->findAll())
            ->addOptionsColumn()
            //            ->sortBy('createdAt', 'DESC')
            //            ->addIncrementalColumn()
            ->build();

            return $this->renderCrudIndex(
            className: <?= $entity ?>::class,
            formType: New<?= $entity ?>Type::class,
            table: $table
            );
        <?php else:?>
        // code to handle index action
        <?php endif;?>
    }

    #[Route('/new', name: 'admin_<?= $entityLowercase ?>_new', methods: ['POST'])]
    public function new()
    {
        <?php if($controller['addMethodBody']):?>
            return $this->processCrudNew(
            className: <?= $entity ?>::class,
            formType: New<?= $entity ?>Type::class,
            );
        <?php else:?>
        // code to handle new action
        <?php endif;?>
    }

    #[Route('/{id}/details', name: 'admin_<?= $entityLowercase ?>_details', methods: ['GET'])]
    public function details(<?= $entity ?> $<?= $entityLowercase ?>, TableGenerator $tableGenerator)
    {
        <?php if($controller['addMethodBody']):?>
            $table = $tableGenerator
            ->addEntities([$<?= $entityLowercase ?>])
            ->setVertical()
            ->build();

            return $this->renderCrudDetails(
            entity: $<?= $entityLowercase ?>,
            table: $table
            );
        <?php else:?>
        // code to handle details action
        <?php endif;?>
    }

    #[Route('/{id}/edit', name: 'admin_<?= $entityLowercase ?>_edit', methods: ['GET', 'POST'])]
    public function edit(<?= $entity ?> $<?= $entityLowercase ?>)
    {
        <?php if($controller['addMethodBody']):?>
            return $this->renderCrudEdit(
            entity: $<?= $entityLowercase ?>,
            formType: <?= $entity ?>Type::class,
            );
        <?php else:?>
        // code to handle edit action
        <?php endif;?>
    }

    #[Route('/{id}', name: 'admin_<?= $entityLowercase ?>_delete', methods: ['POST'])]
    public function delete(<?= $entity ?> $<?= $entityLowercase ?>)
    {
        <?php if($controller['addMethodBody']):?>
            return $this->processCrudDelete(
            entity: $<?= $entityLowercase ?>,
            );
        <?php else:?>
        // code to handle delete action
        <?php endif;?>
    }
}
