<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428100721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order ADD sentence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_order ADD CONSTRAINT FK_93A86C4E27289490 FOREIGN KEY (sentence_id) REFERENCES sentences (id)');
        $this->addSql('CREATE INDEX IDX_93A86C4E27289490 ON page_order (sentence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order DROP FOREIGN KEY FK_93A86C4E27289490');
        $this->addSql('DROP INDEX IDX_93A86C4E27289490 ON page_order');
        $this->addSql('ALTER TABLE page_order DROP sentence_id');
    }
}
