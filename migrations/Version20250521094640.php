<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521094640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_categories_order (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, word_id INT DEFAULT NULL, sentence_id INT DEFAULT NULL, action_id INT DEFAULT NULL, youtube_id INT DEFAULT NULL, next_categorie_id INT DEFAULT NULL, type VARCHAR(3000) NOT NULL, order_display INT NOT NULL, INDEX IDX_8C3FC408BCF5E72D (categorie_id), INDEX IDX_8C3FC408E357438D (word_id), INDEX IDX_8C3FC40827289490 (sentence_id), INDEX IDX_8C3FC4089D32F035 (action_id), INDEX IDX_8C3FC408BB7E40D1 (youtube_id), INDEX IDX_8C3FC4086BFAE7C7 (next_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC408BCF5E72D FOREIGN KEY (categorie_id) REFERENCES user_categories (id)');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC408E357438D FOREIGN KEY (word_id) REFERENCES word (id)');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC40827289490 FOREIGN KEY (sentence_id) REFERENCES sentences (id)');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC4089D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC408BB7E40D1 FOREIGN KEY (youtube_id) REFERENCES youtube (id)');
        $this->addSql('ALTER TABLE user_categories_order ADD CONSTRAINT FK_8C3FC4086BFAE7C7 FOREIGN KEY (next_categorie_id) REFERENCES user_categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC408BCF5E72D');
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC408E357438D');
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC40827289490');
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC4089D32F035');
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC408BB7E40D1');
        $this->addSql('ALTER TABLE user_categories_order DROP FOREIGN KEY FK_8C3FC4086BFAE7C7');
        $this->addSql('DROP TABLE user_categories_order');
    }
}
