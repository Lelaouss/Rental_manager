#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: country
#------------------------------------------------------------

CREATE TABLE country
(
    id_country Int Auto_increment NOT NULL,
    name       Varchar(255)       NOT NULL,
    active     TinyINT            NOT NULL,
    CONSTRAINT country_PK PRIMARY KEY (id_country)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: city
#------------------------------------------------------------

CREATE TABLE city
(
    id_city     Int Auto_increment NOT NULL,
    id_country  Int                NOT NULL,
    name        Varchar(255)       NOT NULL,
    county_name Varchar(255)       NOT NULL,
    zip_code    Varchar(255)       NOT NULL,
    CONSTRAINT city_PK PRIMARY KEY (id_city),
    CONSTRAINT city_country_FK FOREIGN KEY (id_country) REFERENCES country (id_country)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: adress
#------------------------------------------------------------

CREATE TABLE adress
(
    id_adress         Int Auto_increment NOT NULL,
    id_city           Int                NOT NULL,
    street            Varchar(255)       NOT NULL,
    additional_adress Varchar(255),
    CONSTRAINT adress_PK PRIMARY KEY (id_adress),
    CONSTRAINT adress_city_FK FOREIGN KEY (id_city) REFERENCES city (id_city)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: property
#------------------------------------------------------------

CREATE TABLE property
(
    id_property       Int Auto_increment NOT NULL,
    id_adress         Int                NOT NULL,
    label             Varchar(45)        NOT NULL,
    construction_date Datetime,
    purchase_date     Datetime,
    purchase_price    Float,
    sale_date         Datetime,
    sale_price        Float,
    surface_area      Float,
    nb_rooms          Int,
    details           Longtext,
    CONSTRAINT property_PK PRIMARY KEY (id_property),
    CONSTRAINT property_adress_FK FOREIGN KEY (id_adress) REFERENCES adress (id_adress)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: person
#------------------------------------------------------------

CREATE TABLE person
(
    id_person        Int Auto_increment NOT NULL,
    id_adress        Int,
    first_name       Varchar(255)       NOT NULL,
    last_name        Varchar(255)       NOT NULL,
    middle_name      Varchar(255),
    civility         TinyINT            NOT NULL,
    birthday         Datetime,
    mail             Varchar(255),
    cell_phone       Varchar(45),
    landline_phone   Varchar(45),
    family_situation TinyINT,
    occupation       Varchar(255),
    banished         Datetime,
    CONSTRAINT person_PK PRIMARY KEY (id_person),
    CONSTRAINT person_adress_FK FOREIGN KEY (id_adress) REFERENCES adress (id_adress)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: user_type
#------------------------------------------------------------

CREATE TABLE user_type
(
    id_user_type Int Auto_increment NOT NULL,
    label        Varchar(45)        NOT NULL,
    active       TinyINT            NOT NULL,
    CONSTRAINT user_type_PK PRIMARY KEY (id_user_type)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: user
#------------------------------------------------------------

CREATE TABLE user
(
    id_user      Int Auto_increment NOT NULL,
    id_person    Int                NOT NULL,
    id_user_type Int                NOT NULL,
    login        Varchar(45)        NOT NULL,
    password     Varchar(255)       NOT NULL,
    banished     Datetime,
    CONSTRAINT user_PK PRIMARY KEY (id_user),
    CONSTRAINT user_person_FK FOREIGN KEY (id_person) REFERENCES person (id_person),
    CONSTRAINT user_user_type0_FK FOREIGN KEY (id_user_type) REFERENCES user_type (id_user_type),
    CONSTRAINT user_person_AK UNIQUE (id_person)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: document_type
#------------------------------------------------------------

CREATE TABLE document_type
(
    id_document_type Int Auto_increment NOT NULL,
    label            Varchar(255)       NOT NULL,
    active           TinyINT            NOT NULL,
    CONSTRAINT document_type_PK PRIMARY KEY (id_document_type)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: document
#------------------------------------------------------------

CREATE TABLE document
(
    id_document      Int Auto_increment NOT NULL,
    id_document_type Int                NOT NULL,
    label            Varchar(255)       NOT NULL,
    path             Varchar(255)       NOT NULL,
    active           TinyINT            NOT NULL,
    CONSTRAINT document_PK PRIMARY KEY (id_document),
    CONSTRAINT document_document_type_FK FOREIGN KEY (id_document_type) REFERENCES document_type (id_document_type)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: rent
#------------------------------------------------------------

CREATE TABLE rent
(
    id_rent           Int Auto_increment NOT NULL,
    id_property       Int                NOT NULL,
    id_person         Int,
    start_date        Datetime           NOT NULL,
    end_date          Datetime,
    rent_amount       Float              NOT NULL,
    rent_charges      Float              NOT NULL,
    rent_total_amount Float              NOT NULL,
    rent_guarantee    Float              NOT NULL,
    furnished         TinyINT            NOT NULL,
    CONSTRAINT rent_PK PRIMARY KEY (id_rent),
    CONSTRAINT rent_property_FK FOREIGN KEY (id_property) REFERENCES property (id_property),
    CONSTRAINT rent_person0_FK FOREIGN KEY (id_person) REFERENCES person (id_person)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: property__owner
#------------------------------------------------------------

CREATE TABLE property__owner
(
    id_property Int NOT NULL,
    id_person   Int NOT NULL,
    CONSTRAINT property__owner_PK PRIMARY KEY (id_property, id_person),
    CONSTRAINT property__owner_property_FK FOREIGN KEY (id_property) REFERENCES property (id_property),
    CONSTRAINT property__owner_person0_FK FOREIGN KEY (id_person) REFERENCES person (id_person)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: person__rent
#------------------------------------------------------------

CREATE TABLE person__rent
(
    id_rent     Int     NOT NULL,
    id_person   Int     NOT NULL,
    main_tenant TinyINT NOT NULL,
    CONSTRAINT person__rent_PK PRIMARY KEY (id_rent, id_person),
    CONSTRAINT person__rent_rent_FK FOREIGN KEY (id_rent) REFERENCES rent (id_rent),
    CONSTRAINT person__rent_person0_FK FOREIGN KEY (id_person) REFERENCES person (id_person)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: document__rent
#------------------------------------------------------------

CREATE TABLE document__rent
(
    id_rent     Int NOT NULL,
    id_document Int NOT NULL,
    CONSTRAINT document__rent_PK PRIMARY KEY (id_rent, id_document),
    CONSTRAINT document__rent_rent_FK FOREIGN KEY (id_rent) REFERENCES rent (id_rent),
    CONSTRAINT document__rent_document0_FK FOREIGN KEY (id_document) REFERENCES document (id_document)
) ENGINE = InnoDB;


#------------------------------------------------------------
# Table: document__property
#------------------------------------------------------------

CREATE TABLE document__property
(
    id_document Int NOT NULL,
    id_property Int NOT NULL,
    CONSTRAINT document__property_PK PRIMARY KEY (id_document, id_property),
    CONSTRAINT document__property_document_FK FOREIGN KEY (id_document) REFERENCES document (id_document),
    CONSTRAINT document__property_property0_FK FOREIGN KEY (id_property) REFERENCES property (id_property)
) ENGINE = InnoDB;

