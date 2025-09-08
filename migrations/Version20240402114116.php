<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402114116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE word_categories (word_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_530474CAE357438D (word_id), INDEX IDX_530474CAA21214B7 (categories_id), PRIMARY KEY(word_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word_categories ADD CONSTRAINT FK_530474CAE357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE word_categories ADD CONSTRAINT FK_530474CAA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word_categories DROP FOREIGN KEY FK_530474CAE357438D');
        $this->addSql('ALTER TABLE word_categories DROP FOREIGN KEY FK_530474CAA21214B7');
        $this->addSql('DROP TABLE word_categories');
    }
}
