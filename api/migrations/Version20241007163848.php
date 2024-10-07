<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007163848 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE user_users ALTER confirm_expire_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE user_users ALTER reset_expire_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER change_email_expire_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN user_users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.confirm_expire_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.reset_expire_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.change_email_expire_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_networks ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_networks ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE access_tokens ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER new_email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_users ALTER created_at TYPE DATE');
        $this->addSql('ALTER TABLE user_users ALTER confirm_expire_at TYPE DATE');
        $this->addSql('ALTER TABLE user_users ALTER reset_expire_at TYPE DATE');
        $this->addSql('ALTER TABLE user_users ALTER change_email_expire_at TYPE DATE');
        $this->addSql('COMMENT ON COLUMN user_users.created_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.confirm_expire_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.reset_expire_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.change_email_expire_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE user_profiles ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER user_id TYPE UUID');
        $this->addSql('ALTER TABLE user_profiles ALTER email TYPE VARCHAR(255)');
    }
}
