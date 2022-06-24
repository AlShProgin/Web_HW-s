<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624034000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD name_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F71179CD6 FOREIGN KEY (name_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F71179CD6 ON message (name_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F71179CD6');
        $this->addSql('DROP INDEX IDX_B6BD307F71179CD6 ON message');
        $this->addSql('ALTER TABLE message ADD name VARCHAR(40) NOT NULL, DROP name_id');
    }
}
