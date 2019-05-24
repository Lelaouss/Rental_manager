<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190519085024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE county (id_county INT AUTO_INCREMENT NOT NULL, id_country_id INT NOT NULL, name VARCHAR(255) NOT NULL, code INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_58E2FF255CA5BEA7 (id_country_id), PRIMARY KEY(id_county)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE county ADD CONSTRAINT FK_58E2FF255CA5BEA7 FOREIGN KEY (id_country_id) REFERENCES country (id_country)');
        $this->addSql('ALTER TABLE adress CHANGE id_city id_city INT NOT NULL, CHANGE additional_adress additional_adress VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY city_country_FK');
        $this->addSql('DROP INDEX city_country_FK ON city');
        $this->addSql('ALTER TABLE city ADD id_county_id INT NOT NULL, DROP id_country, DROP county_name');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02345D28362 FOREIGN KEY (id_county_id) REFERENCES county (id_county)');
        $this->addSql('CREATE INDEX IDX_2D5B02345D28362 ON city (id_county_id)');
        $this->addSql('ALTER TABLE person CHANGE middle_name middle_name VARCHAR(255) DEFAULT \'NULL\', CHANGE birthday birthday DATETIME DEFAULT \'NULL\', CHANGE mail mail VARCHAR(255) DEFAULT \'NULL\', CHANGE cell_phone cell_phone VARCHAR(45) DEFAULT \'NULL\', CHANGE landline_phone landline_phone VARCHAR(45) DEFAULT \'NULL\', CHANGE family_situation family_situation TINYINT(1) DEFAULT \'NULL\', CHANGE occupation occupation VARCHAR(255) DEFAULT \'NULL\', CHANGE banished banished DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT NOT NULL, CHANGE construction_date construction_date DATETIME DEFAULT \'NULL\', CHANGE purchase_date purchase_date DATETIME DEFAULT \'NULL\', CHANGE purchase_price purchase_price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE sale_date sale_date DATETIME DEFAULT \'NULL\', CHANGE sale_price sale_price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE surface_area surface_area DOUBLE PRECISION DEFAULT \'NULL\', CHANGE nb_rooms nb_rooms INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent CHANGE end_date end_date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE banished banished DATETIME DEFAULT \'NULL\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02345D28362');
        $this->addSql('DROP TABLE county');
        $this->addSql('ALTER TABLE adress CHANGE id_city id_city INT DEFAULT NULL, CHANGE additional_adress additional_adress VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci');
        $this->addSql('DROP INDEX IDX_2D5B02345D28362 ON city');
        $this->addSql('ALTER TABLE city ADD id_country INT DEFAULT NULL, ADD county_name VARCHAR(255) NOT NULL COLLATE utf8_general_ci, DROP id_county_id');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT city_country_FK FOREIGN KEY (id_country) REFERENCES country (id_country) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX city_country_FK ON city (id_country)');
        $this->addSql('ALTER TABLE person CHANGE middle_name middle_name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE birthday birthday DATETIME DEFAULT NULL, CHANGE mail mail VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE cell_phone cell_phone VARCHAR(45) DEFAULT NULL COLLATE utf8_general_ci, CHANGE landline_phone landline_phone VARCHAR(45) DEFAULT NULL COLLATE utf8_general_ci, CHANGE family_situation family_situation TINYINT(1) DEFAULT NULL, CHANGE occupation occupation VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, CHANGE banished banished DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT DEFAULT NULL, CHANGE construction_date construction_date DATETIME DEFAULT NULL, CHANGE purchase_date purchase_date DATETIME DEFAULT NULL, CHANGE purchase_price purchase_price DOUBLE PRECISION DEFAULT NULL, CHANGE sale_date sale_date DATETIME DEFAULT NULL, CHANGE sale_price sale_price DOUBLE PRECISION DEFAULT NULL, CHANGE surface_area surface_area DOUBLE PRECISION DEFAULT NULL, CHANGE nb_rooms nb_rooms INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rent CHANGE end_date end_date DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649AA08CB10 ON user');
        $this->addSql('ALTER TABLE user CHANGE banished banished DATETIME DEFAULT NULL');
    }
}
