<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190409094356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adress CHANGE id_city id_city INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city CHANGE id_country id_country INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE id_document_type id_document_type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent CHANGE id_property id_property INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adress CHANGE id_city id_city INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city CHANGE id_country id_country INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE id_document_type id_document_type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent CHANGE id_property id_property INT DEFAULT NULL');
    }
}
