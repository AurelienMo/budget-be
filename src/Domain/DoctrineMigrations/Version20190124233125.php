<?php

declare(strict_types=1);

namespace App\Domain\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124233125 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_group_user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, token_activation VARCHAR(255) DEFAULT NULL, token_reset_password VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7C34BEA944949A20 (amo_group_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_account (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_cfg_bank_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', amo_user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', initial_balance DOUBLE PRECISION NOT NULL, balance DOUBLE PRECISION NOT NULL, display_in_group TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_314251115D3205BE (amo_cfg_bank_id), INDEX IDX_31425111EB1AD420 (amo_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_group_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_owner_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_7F75926CC57B52FD (amo_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_user ADD CONSTRAINT FK_7C34BEA944949A20 FOREIGN KEY (amo_group_user_id) REFERENCES amo_group_user (id)');
        $this->addSql('ALTER TABLE amo_account ADD CONSTRAINT FK_314251115D3205BE FOREIGN KEY (amo_cfg_bank_id) REFERENCES amo_cfg_bank (id)');
        $this->addSql('ALTER TABLE amo_account ADD CONSTRAINT FK_31425111EB1AD420 FOREIGN KEY (amo_user_id) REFERENCES amo_user (id)');
        $this->addSql('ALTER TABLE amo_group_user ADD CONSTRAINT FK_7F75926CC57B52FD FOREIGN KEY (amo_owner_id) REFERENCES amo_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_account DROP FOREIGN KEY FK_31425111EB1AD420');
        $this->addSql('ALTER TABLE amo_group_user DROP FOREIGN KEY FK_7F75926CC57B52FD');
        $this->addSql('ALTER TABLE amo_user DROP FOREIGN KEY FK_7C34BEA944949A20');
        $this->addSql('DROP TABLE amo_user');
        $this->addSql('DROP TABLE amo_account');
        $this->addSql('DROP TABLE amo_group_user');
    }
}
