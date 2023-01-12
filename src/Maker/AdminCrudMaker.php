<?php
declare (strict_types=1);

namespace App\Maker;

use App\Helper\StringHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;


class AdminCrudMaker extends AbstractMaker
{
    private ConsoleStyle $io;


    public function __construct(private EntityManagerInterface $em)
    {
    }

    public static function getCommandName(): string
    {
        return 'make:kropla:admin-crud';
    }

    public static function getCommandDescription(): string
    {
        return 'Makes admin crud';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
//        $command->addArgument('entityName', InputArgument::REQUIRED, 'The entity name');
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // TODO: Implement configureDependencies() method.
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $this->setIo($io);

        $fields = $this->getFieldsFromInput($io);

        $this->generateFormTypes($generator, $fields);

        $this->generateCrudController($generator, $fields);

        $generator->writeChanges();
    }

    private function generateCrudController(Generator $generator, array $fields): void
    {
        $generator->generateClass(
            $fields['controller']['fqn'],
            __DIR__ . '/../Resources/skeleton/crudController.tpl.php',
            $fields
        );
    }

    private function generateFormTypes(Generator $generator, $fields): void
    {
        if ($fields['generateFormTypes']) {
            $generator->generateClass(
                $fields['formType']['fqn'],
                __DIR__ . '/../Resources/skeleton/formType.tpl.php',
                $fields
            );

            $primaryProperties = ['title', 'name', 'label', 'email', 'username', 'nickname', 'headline'];
            $fields['newFormType']['primaryField'] = StringHelper::getFirstMatchingString($this->findMappedProperties($fields['entityFqn']), $primaryProperties);

            if ($fields['newFormType']['primaryField']) {
                $generator->generateClass(
                    $fields['newFormType']['fqn'],
                    __DIR__ . '/../Resources/skeleton/newFormType.tpl.php',
                    $fields
                );
            } else {
                $this->getIo()->warning(
                    sprintf('File %s was skipped because generator could not find primary property. Please make this file on your own.',
                        $fields['formType']['fqn']
                    )
                );
            }

        }
    }

    private function findEntities(): array
    {
        $entities = $this->em->getMetadataFactory()->getAllMetadata();
        return array_map(static function ($metadata) {
            return $metadata->getName();
        }, $entities);
    }

    private function findMappedProperties(string $classname): array
    {
        $metadata = $this->em->getMetadataFactory()->getMetadataFor($classname);

        return $metadata->getFieldNames();
    }

    private function getFieldsFromInput(ConsoleStyle $io): array
    {
        $fields['entityFqn'] = $io->choice(
            'Which entity do you want to generate a CRUD controller for?',
            $this->findEntities(),
        );
        $fields['entity'] = basename($fields['entityFqn']);
        $fields['entityLowercase'] = strtolower($fields['entity']);

        //Controller
        $fields['controller']['addMethodBody'] = $io->choice(
                'Include default templates for tables, forms, etc. in the generated methods?',
                ['yes', 'no'],
                'yes'
            ) === 'yes';
        $fields['controller']['namespace'] = 'App\Controller\Admin\Crud';
        $fields['controller']['className'] = 'Admin' . $fields['entity'] . 'Controller';
        $fields['controller']['fqn'] = $fields['controller']['namespace'] . '\\' . $fields['controller']['className'];


        //FormType
        $fields['generateFormTypes'] = $io->choice(
                "Generate default form types for the controller? (<fg=magenta>{$fields['entity']}Type.php</> , <fg=magenta>New{$fields['entity']}Type.php</>)",
                ['yes', 'no'],
                'yes'
            ) === 'yes';
        if ($fields['generateFormTypes']) {
            $fields['formType']['namespace'] = 'App\Form';
            $fields['formType']['className'] = $fields['entity'] . 'Type';
            $fields['formType']['fqn'] = $fields['formType']['namespace'] . '\\' . $fields['formType']['className'];
            $fields['newFormType']['fqn'] = $fields['formType']['namespace'] . '\\' . 'New' . $fields['formType']['className'];
            $fields['formType']['properties'] = $this->findMappedProperties($fields['entityFqn']);
        }


        return $fields;
    }


    public function getIo(): ConsoleStyle
    {
        return $this->io;
    }

    public function setIo(ConsoleStyle $io): void
    {
        $this->io = $io;
    }
}