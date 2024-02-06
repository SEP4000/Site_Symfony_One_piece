<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326104817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C41EB8A3C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5E315342');
        $this->addSql('DROP INDEX IDX_9474526C5E315342 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C41EB8A3C ON comment');
        $this->addSql('ALTER TABLE comment ADD arcs_id INT NOT NULL, ADD personnages_id INT NOT NULL, DROP arc_id, DROP personnage_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC85F2A28 FOREIGN KEY (arcs_id) REFERENCES arc (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7FFDACCA FOREIGN KEY (personnages_id) REFERENCES personnage (id)');
        $this->addSql('CREATE INDEX IDX_9474526CC85F2A28 ON comment (arcs_id)');
        $this->addSql('CREATE INDEX IDX_9474526C7FFDACCA ON comment (personnages_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CC85F2A28');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7FFDACCA');
        $this->addSql('DROP INDEX IDX_9474526CC85F2A28 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C7FFDACCA ON comment');
        $this->addSql('ALTER TABLE comment ADD arc_id INT NOT NULL, ADD personnage_id INT NOT NULL, DROP arcs_id, DROP personnages_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41EB8A3C FOREIGN KEY (arc_id) REFERENCES arc (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5E315342 ON comment (personnage_id)');
        $this->addSql('CREATE INDEX IDX_9474526C41EB8A3C ON comment (arc_id)');
    }
}
