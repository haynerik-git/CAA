<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251002130248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order ADD page_picto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_order ADD CONSTRAINT FK_93A86C4E2FB48063 FOREIGN KEY (page_picto_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_93A86C4E2FB48063 ON page_order (page_picto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order DROP FOREIGN KEY FK_93A86C4E2FB48063');
        $this->addSql('DROP INDEX IDX_93A86C4E2FB48063 ON page_order');
        $this->addSql('ALTER TABLE page_order DROP page_picto_id');
    }
}
