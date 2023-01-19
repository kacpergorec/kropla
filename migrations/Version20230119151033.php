<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119151033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD tags JSON DEFAULT NULL, CHANGE content content LONGTEXT DEFAULT NULL, CHANGE redirect_url redirect_url VARCHAR(1024) DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD tags JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP tags');
        $this->addSql('ALTER TABLE page DROP tags, CHANGE content content VARCHAR(255) DEFAULT NULL, CHANGE redirect_url redirect_url VARCHAR(255) DEFAULT NULL');
    }
}
