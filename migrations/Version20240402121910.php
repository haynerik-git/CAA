<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402121910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE word_translation (id INT AUTO_INCREMENT NOT NULL, word_translation_id INT DEFAULT NULL, lang_id INT NOT NULL, name VARCHAR(2500) NOT NULL, INDEX IDX_8CD8709933B465D3 (word_translation_id), INDEX IDX_8CD87099B213FA4 (lang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE word_translation ADD CONSTRAINT FK_8CD8709933B465D3 FOREIGN KEY (word_translation_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE word_translation ADD CONSTRAINT FK_8CD87099B213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE word_translation DROP FOREIGN KEY FK_8CD8709933B465D3');
        $this->addSql('ALTER TABLE word_translation DROP FOREIGN KEY FK_8CD87099B213FA4');
        $this->addSql('DROP TABLE word_translation');
    }
}
