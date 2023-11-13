<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111192414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel CHANGE idParc idParc INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091B921AB9F FOREIGN KEY (idParc) REFERENCES parc (idParc)');
        $this->addSql('DROP INDEX idparc ON materiel');
        $this->addSql('CREATE INDEX IDX_18D2B091B921AB9F ON materiel (idParc)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091B921AB9F');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091B921AB9F');
        $this->addSql('ALTER TABLE materiel CHANGE idParc idParc INT NOT NULL');
        $this->addSql('DROP INDEX idx_18d2b091b921ab9f ON materiel');
        $this->addSql('CREATE INDEX idParc ON materiel (idParc)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091B921AB9F FOREIGN KEY (idParc) REFERENCES parc (idParc)');
    }
}
