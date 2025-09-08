<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402133116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_categories (categories_source INT NOT NULL, categories_target INT NOT NULL, INDEX IDX_9B7D066057E3414B (categories_source), INDEX IDX_9B7D06604E0611C4 (categories_target), PRIMARY KEY(categories_source, categories_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_categories ADD CONSTRAINT FK_9B7D066057E3414B FOREIGN KEY (categories_source) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_categories ADD CONSTRAINT FK_9B7D06604E0611C4 FOREIGN KEY (categories_target) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_categories DROP FOREIGN KEY FK_9B7D066057E3414B');
        $this->addSql('ALTER TABLE categories_categories DROP FOREIGN KEY FK_9B7D06604E0611C4');
        $this->addSql('DROP TABLE categories_categories');
    }
}
