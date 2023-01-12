<?= "<?php\n" ?>

namespace <?= $formType['namespace'] ?>;

use App\Entity\<?=$entity?>;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class New<?=$entity?>Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->setAction('new')
        ->add('submit', SubmitType::class)
        ->add('<?=$newFormType['primaryField']?>')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => <?=$entity?>::class,
        ]);
    }
}
