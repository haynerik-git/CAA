<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402204436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sentences_word (sentences_id INT NOT NULL, word_id INT NOT NULL, INDEX IDX_2A34C413175906F5 (sentences_id), INDEX IDX_2A34C413E357438D (word_id), PRIMARY KEY(sentences_id, word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sentences_word ADD CONSTRAINT FK_2A34C413175906F5 FOREIGN KEY (sentences_id) REFERENCES sentences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sentences_word ADD CONSTRAINT FK_2A34C413E357438D FOREIGN KEY (word_id) REFERENCES word (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentences_word DROP FOREIGN KEY FK_2A34C413175906F5');
        $this->addSql('ALTER TABLE sentences_word DROP FOREIGN KEY FK_2A34C413E357438D');
        $this->addSql('DROP TABLE sentences_word');
    }
}
