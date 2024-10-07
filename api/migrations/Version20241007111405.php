<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007111405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_tokens ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profiles DROP email');
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
    }
}
