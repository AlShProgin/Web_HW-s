<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624112637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD chat_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7E3973CC FOREIGN KEY (chat_id_id) REFERENCES chat (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3973CC ON message (chat_id_id)');
        $this->addSql('ALTER TABLE user_chat_list DROP FOREIGN KEY FK_E2B4E8BD67B3B43D');
        $this->addSql('DROP INDEX IDX_E2B4E8BD67B3B43D ON user_chat_list');
        $this->addSql('ALTER TABLE user_chat_list CHANGE users_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_chat_list ADD CONSTRAINT FK_E2B4E8BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E2B4E8BDA76ED395 ON user_chat_list (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F7E3973CC');
        $this->addSql('DROP INDEX IDX_B6BD307F7E3973CC ON message');
        $this->addSql('ALTER TABLE message DROP chat_id_id');
        $this->addSql('ALTER TABLE user_chat_list DROP FOREIGN KEY FK_E2B4E8BDA76ED395');
        $this->addSql('DROP INDEX IDX_E2B4E8BDA76ED395 ON user_chat_list');
        $this->addSql('ALTER TABLE user_chat_list CHANGE user_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_chat_list ADD CONSTRAINT FK_E2B4E8BD67B3B43D FOREIGN KEY (users_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E2B4E8BD67B3B43D ON user_chat_list (users_id)');
    }
}
