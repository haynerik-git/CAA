<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930191345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, lang_id INT NOT NULL, name VARCHAR(2500) NOT NULL, INDEX IDX_A3D51B1DC4663E4 (page_id), INDEX IDX_A3D51B1DB213FA4 (lang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1DC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1DB213FA4 FOREIGN KEY (lang_id) REFERENCES lang (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY FK_A3D51B1DC4663E4');
        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY FK_A3D51B1DB213FA4');
        $this->addSql('DROP TABLE page_translation');
    }
}
