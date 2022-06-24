<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624111746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY fk_message_chat');
        $this->addSql('DROP INDEX fk_message_chat ON message');
        $this->addSql('ALTER TABLE message DROP chat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD chat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_message_chat FOREIGN KEY (chat_id) REFERENCES chat (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_message_chat ON message (chat_id)');
    }
}
