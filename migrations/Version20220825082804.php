<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825082804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP mdp, DROP statut, CHANGE pseudo pseudo VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB2986CC499D ON membre (pseudo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F6B4FB2986CC499D ON membre');
        $this->addSql('ALTER TABLE membre ADD mdp VARCHAR(60) NOT NULL, ADD statut INT NOT NULL, DROP roles, DROP password, CHANGE pseudo pseudo VARCHAR(20) NOT NULL');
    }
}
