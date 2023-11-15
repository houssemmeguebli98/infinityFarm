<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115133829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel CHANGE idParc idparc INT DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091191304A1 FOREIGN KEY (idparc) REFERENCES parc (idparc)');
        $this->addSql('DROP INDEX idparc ON materiel');
        $this->addSql('CREATE INDEX IDX_18D2B091191304A1 ON materiel (idparc)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091191304A1');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091191304A1');
        $this->addSql('ALTER TABLE materiel CHANGE idparc idParc INT NOT NULL');
        $this->addSql('DROP INDEX idx_18d2b091191304a1 ON materiel');
        $this->addSql('CREATE INDEX idParc ON materiel (idParc)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091191304A1 FOREIGN KEY (idparc) REFERENCES parc (idparc)');
    }
}
