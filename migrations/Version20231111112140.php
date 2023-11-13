<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111112140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel ADD idParc INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091B921AB9F FOREIGN KEY (idParc) REFERENCES parc (idParc)');
        $this->addSql('CREATE INDEX IDX_18D2B091B921AB9F ON materiel (idParc)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091B921AB9F');
        $this->addSql('DROP INDEX IDX_18D2B091B921AB9F ON materiel');
        $this->addSql('ALTER TABLE materiel DROP idParc');
    }
}
