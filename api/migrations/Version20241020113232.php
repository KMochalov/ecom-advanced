<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241020113232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, parent_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AF34668727ACA70 ON categories (parent_id)');
        $this->addSql('CREATE TABLE characteristic (id UUID NOT NULL, unit_of_measurement_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_522FA950DA7C9F35 ON characteristic (unit_of_measurement_id)');
        $this->addSql('CREATE TABLE characteristic_value (id UUID NOT NULL, variant_id UUID DEFAULT NULL, characteristic_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_719F040E3B69A9AF ON characteristic_value (variant_id)');
        $this->addSql('CREATE INDEX IDX_719F040EDEE9D12B ON characteristic_value (characteristic_id)');
        $this->addSql('CREATE TABLE product_characteristic (id UUID NOT NULL, product_id UUID DEFAULT NULL, characteristic_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_146D77C4584665A ON product_characteristic (product_id)');
        $this->addSql('CREATE INDEX IDX_146D77CDEE9D12B ON product_characteristic (characteristic_id)');
        $this->addSql('CREATE TABLE product_variant (id UUID NOT NULL, product_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_209AA41D4584665A ON product_variant (product_id)');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, category_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('CREATE TABLE unit_of_measurement (id UUID NOT NULL, name VARCHAR(36) NOT NULL, short_name VARCHAR(36) NOT NULL, type VARCHAR(36) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668727ACA70 FOREIGN KEY (parent_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristic ADD CONSTRAINT FK_522FA950DA7C9F35 FOREIGN KEY (unit_of_measurement_id) REFERENCES unit_of_measurement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristic_value ADD CONSTRAINT FK_719F040E3B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE characteristic_value ADD CONSTRAINT FK_719F040EDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_characteristic ADD CONSTRAINT FK_146D77C4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_characteristic ADD CONSTRAINT FK_146D77CDEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE access_tokens ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668727ACA70');
        $this->addSql('ALTER TABLE characteristic DROP CONSTRAINT FK_522FA950DA7C9F35');
        $this->addSql('ALTER TABLE characteristic_value DROP CONSTRAINT FK_719F040E3B69A9AF');
        $this->addSql('ALTER TABLE characteristic_value DROP CONSTRAINT FK_719F040EDEE9D12B');
        $this->addSql('ALTER TABLE product_characteristic DROP CONSTRAINT FK_146D77C4584665A');
        $this->addSql('ALTER TABLE product_characteristic DROP CONSTRAINT FK_146D77CDEE9D12B');
        $this->addSql('ALTER TABLE product_variant DROP CONSTRAINT FK_209AA41D4584665A');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A12469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('DROP TABLE characteristic_value');
        $this->addSql('DROP TABLE product_characteristic');
        $this->addSql('DROP TABLE product_variant');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE unit_of_measurement');
        $this->addSql('ALTER TABLE user_networks ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
    }
}
