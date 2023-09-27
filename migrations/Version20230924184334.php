<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924184334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre_livre (genre_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_1165505C4296D31F (genre_id), INDEX IDX_1165505C37D925CB (livre_id), PRIMARY KEY(genre_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunteur ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunteur ADD CONSTRAINT FK_952067DE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_952067DE9D86650F ON emprunteur (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre_livre DROP FOREIGN KEY FK_1165505C4296D31F');
        $this->addSql('ALTER TABLE genre_livre DROP FOREIGN KEY FK_1165505C37D925CB');
        $this->addSql('DROP TABLE genre_livre');
        $this->addSql('ALTER TABLE emprunteur DROP FOREIGN KEY FK_952067DE9D86650F');
        $this->addSql('DROP INDEX UNIQ_952067DE9D86650F ON emprunteur');
        $this->addSql('ALTER TABLE emprunteur DROP user_id_id');
    }
}
