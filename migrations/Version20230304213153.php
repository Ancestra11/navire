<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304213153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE escale ADD idnavire INT NOT NULL, ADD idport INT NOT NULL, ADD dateHeureArrivee DATETIME NOT NULL, ADD dateHeureDepart DATETIME DEFAULT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX IDX_C39FEDD36A50BD94 ON escale (idnavire)');
        $this->addSql('CREATE INDEX IDX_C39FEDD3905EAC6C ON escale (idport)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD36A50BD94');
        $this->addSql('ALTER TABLE escale DROP FOREIGN KEY FK_C39FEDD3905EAC6C');
        $this->addSql('DROP INDEX IDX_C39FEDD36A50BD94 ON escale');
        $this->addSql('DROP INDEX IDX_C39FEDD3905EAC6C ON escale');
        $this->addSql('ALTER TABLE escale DROP idnavire, DROP idport, DROP dateHeureArrivee, DROP dateHeureDepart, CHANGE id id INT NOT NULL');
    }
}
