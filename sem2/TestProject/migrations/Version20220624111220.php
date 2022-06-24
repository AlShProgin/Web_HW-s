<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624111220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_chat_list (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, chat_id INT NOT NULL, INDEX IDX_E2B4E8BD67B3B43D (users_id), INDEX IDX_E2B4E8BD1A9A7125 (chat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_chat_list ADD CONSTRAINT FK_E2B4E8BD67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_chat_list ADD CONSTRAINT FK_E2B4E8BD1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_chat_list');
    }
}
