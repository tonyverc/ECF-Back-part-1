<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927083715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunteur DROP FOREIGN KEY FK_952067DE9D86650F');
        $this->addSql('DROP INDEX UNIQ_952067DE9D86650F ON emprunteur');
        $this->addSql('ALTER TABLE emprunteur CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunteur ADD CONSTRAINT FK_952067DEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_952067DEA76ED395 ON emprunteur (user_id)');
        $this->addSql('ALTER TABLE genre CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunteur DROP FOREIGN KEY FK_952067DEA76ED395');
        $this->addSql('DROP INDEX UNIQ_952067DEA76ED395 ON emprunteur');
        $this->addSql('ALTER TABLE emprunteur CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunteur ADD CONSTRAINT FK_952067DE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_952067DE9D86650F ON emprunteur (user_id_id)');
        $this->addSql('ALTER TABLE genre CHANGE description description LONGTEXT NOT NULL');
    }
}
