<?= "<?php\n" ?>

namespace <?= $formType['namespace'] ?>;

use App\Entity\<?=$entity?>;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class <?=$entity?>Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        <?php foreach ($formType['properties'] as $property): ?>
        ->add('<?=$property?>')
        <?php endforeach; ?>;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-control',
//              Use custom template if needed
//                'template' => 'admin/forms/page_form.html.twig'
            ],
            'data_class' => <?=$entity?>::class,
        ]);
    }
}
