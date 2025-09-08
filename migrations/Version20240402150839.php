<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402150839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_translation (id INT AUTO_INCREMENT NOT NULL, lang_id INT NOT NULL, categories_translation_id INT NOT NULL, name VARCHAR(2500) NOT NULL, INDEX IDX_BA13431DB213FA4 (lang_id), INDEX IDX_BA13431D2D55A8B1 (categories_translation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_translation ADD CONSTRAINT FK_BA13431DB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id)');
        $this->addSql('ALTER TABLE categories_translation ADD CONSTRAINT FK_BA13431D2D55A8B1 FOREIGN KEY (categories_translation_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_translation DROP FOREIGN KEY FK_BA13431DB213FA4');
        $this->addSql('ALTER TABLE categories_translation DROP FOREIGN KEY FK_BA13431D2D55A8B1');
        $this->addSql('DROP TABLE categories_translation');
    }
}
