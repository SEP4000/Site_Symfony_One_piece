<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222085124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage ADD arc_id INT NOT NULL');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D41EB8A3C FOREIGN KEY (arc_id) REFERENCES arc (id)');
        $this->addSql('CREATE INDEX IDX_6AEA486D41EB8A3C ON personnage (arc_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D41EB8A3C');
        $this->addSql('DROP INDEX IDX_6AEA486D41EB8A3C ON personnage');
        $this->addSql('ALTER TABLE personnage DROP arc_id');
    }
}
