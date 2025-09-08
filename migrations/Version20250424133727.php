<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424133727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_order ADD CONSTRAINT FK_93A86C4EA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_93A86C4EA21214B7 ON page_order (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_order DROP FOREIGN KEY FK_93A86C4EA21214B7');
        $this->addSql('DROP INDEX IDX_93A86C4EA21214B7 ON page_order');
        $this->addSql('ALTER TABLE page_order DROP categories_id');
    }
}
