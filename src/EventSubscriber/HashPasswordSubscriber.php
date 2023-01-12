<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use InvalidArgumentException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class HashPasswordSubscriber implements EventSubscriber
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(prePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        $manager = $args->getObjectManager();

        if (!$entity instanceof User) {
            throw new InvalidArgumentException('Persisted entity must be instance of User');
        }

        $this->hashPassword($entity);

        $manager->flush();
    }

    private function hashPassword(User $entity): void
    {

        if (!$entity->getPassword()) {
            throw new InvalidArgumentException('Password must be filled');
        }

        $encoded = $this->userPasswordHasher->hashPassword($entity, $entity->getPassword());

        $entity->setPassword($encoded);
    }
}
