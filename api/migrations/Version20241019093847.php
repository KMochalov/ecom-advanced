<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241019093847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, category_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
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
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A12469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE products');
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
