<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190409073751 extends AbstractMigration
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
        $this->addSql('ALTER TABLE document__property DROP FOREIGN KEY document__property_property0_FK');
        $this->addSql('DROP INDEX document__property_property0_fk ON document__property');
        $this->addSql('CREATE INDEX IDX_B70A711FDB29F04B ON document__property (id_property)');
        $this->addSql('ALTER TABLE document__property ADD CONSTRAINT document__property_property0_FK FOREIGN KEY (id_property) REFERENCES property (id_property)');
        $this->addSql('ALTER TABLE person CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property__owner DROP FOREIGN KEY property__owner_person0_FK');
        $this->addSql('DROP INDEX property__owner_person0_fk ON property__owner');
        $this->addSql('CREATE INDEX IDX_3B2F659C21E5A74C ON property__owner (id_owner)');
        $this->addSql('ALTER TABLE property__owner ADD CONSTRAINT property__owner_person0_FK FOREIGN KEY (id_owner) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE rent CHANGE id_property id_property INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document__rent DROP FOREIGN KEY document__rent_document0_FK');
        $this->addSql('DROP INDEX document__rent_document0_fk ON document__rent');
        $this->addSql('CREATE INDEX IDX_36FC4BA588B266E3 ON document__rent (id_document)');
        $this->addSql('ALTER TABLE document__rent ADD CONSTRAINT document__rent_document0_FK FOREIGN KEY (id_document) REFERENCES document (id_document)');
        $this->addSql('ALTER TABLE person__rent DROP FOREIGN KEY person__rent_person0_FK');
        $this->addSql('ALTER TABLE person__rent DROP main_tenant');
        $this->addSql('DROP INDEX person__rent_person0_fk ON person__rent');
        $this->addSql('CREATE INDEX IDX_F36B2213686E718F ON person__rent (id_tenant)');
        $this->addSql('ALTER TABLE person__rent ADD CONSTRAINT person__rent_person0_FK FOREIGN KEY (id_tenant) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE person__rent__guarantor DROP FOREIGN KEY person__rent__guarantor_person0_FK');
        $this->addSql('DROP INDEX person__rent__guarantor_person0_fk ON person__rent__guarantor');
        $this->addSql('CREATE INDEX IDX_DC14D907A19849B2 ON person__rent__guarantor (id_guarantor)');
        $this->addSql('ALTER TABLE person__rent__guarantor ADD CONSTRAINT person__rent__guarantor_person0_FK FOREIGN KEY (id_guarantor) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE user CHANGE id_person id_person INT DEFAULT NULL, CHANGE id_user_type id_user_type INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adress CHANGE id_city id_city INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city CHANGE id_country id_country INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE id_document_type id_document_type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document__property DROP FOREIGN KEY FK_B70A711FDB29F04B');
        $this->addSql('DROP INDEX idx_b70a711fdb29f04b ON document__property');
        $this->addSql('CREATE INDEX document__property_property0_FK ON document__property (id_property)');
        $this->addSql('ALTER TABLE document__property ADD CONSTRAINT FK_B70A711FDB29F04B FOREIGN KEY (id_property) REFERENCES property (id_property)');
        $this->addSql('ALTER TABLE document__rent DROP FOREIGN KEY FK_36FC4BA588B266E3');
        $this->addSql('DROP INDEX idx_36fc4ba588b266e3 ON document__rent');
        $this->addSql('CREATE INDEX document__rent_document0_FK ON document__rent (id_document)');
        $this->addSql('ALTER TABLE document__rent ADD CONSTRAINT FK_36FC4BA588B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document)');
        $this->addSql('ALTER TABLE person CHANGE id_adress id_adress INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person__rent DROP FOREIGN KEY FK_F36B2213686E718F');
        $this->addSql('ALTER TABLE person__rent ADD main_tenant TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX idx_f36b2213686e718f ON person__rent');
        $this->addSql('CREATE INDEX person__rent_person0_FK ON person__rent (id_tenant)');
        $this->addSql('ALTER TABLE person__rent ADD CONSTRAINT FK_F36B2213686E718F FOREIGN KEY (id_tenant) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE person__rent__guarantor DROP FOREIGN KEY FK_DC14D907A19849B2');
        $this->addSql('DROP INDEX idx_dc14d907a19849b2 ON person__rent__guarantor');
        $this->addSql('CREATE INDEX person__rent__guarantor_person0_FK ON person__rent__guarantor (id_guarantor)');
        $this->addSql('ALTER TABLE person__rent__guarantor ADD CONSTRAINT FK_DC14D907A19849B2 FOREIGN KEY (id_guarantor) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE property CHANGE id_adress id_adress INT NOT NULL');
        $this->addSql('ALTER TABLE property__owner DROP FOREIGN KEY FK_3B2F659C21E5A74C');
        $this->addSql('DROP INDEX idx_3b2f659c21e5a74c ON property__owner');
        $this->addSql('CREATE INDEX property__owner_person0_FK ON property__owner (id_owner)');
        $this->addSql('ALTER TABLE property__owner ADD CONSTRAINT FK_3B2F659C21E5A74C FOREIGN KEY (id_owner) REFERENCES person (id_person)');
        $this->addSql('ALTER TABLE rent CHANGE id_property id_property INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id_person id_person INT NOT NULL, CHANGE id_user_type id_user_type INT NOT NULL');
    }
}
