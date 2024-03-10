<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310205812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events ADD created_event_start_at DATETIME NOT NULL, ADD created_event_end_at DATETIME NOT NULL, DROP created_event_start, DROP created_event_end');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events ADD created_event_start DATETIME NOT NULL, ADD created_event_end DATETIME NOT NULL, DROP created_event_start_at, DROP created_event_end_at');
    }
}
