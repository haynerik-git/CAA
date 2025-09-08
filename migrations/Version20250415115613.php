<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415115613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_categorie_words ADD word_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_categorie_words ADD CONSTRAINT FK_96D99FD3E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('CREATE INDEX IDX_96D99FD3E357438D ON user_categorie_words (word_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_categorie_words DROP FOREIGN KEY FK_96D99FD3E357438D');
        $this->addSql('DROP INDEX IDX_96D99FD3E357438D ON user_categorie_words');
        $this->addSql('ALTER TABLE user_categorie_words DROP word_id');
    }
}
