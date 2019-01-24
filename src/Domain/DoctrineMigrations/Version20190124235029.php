<?php

declare(strict_types=1);

namespace App\Domain\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124235029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_operation_auto (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_cfg_category_operation_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', amo_cfg_type_operation_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', amo_account_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', activated TINYINT(1) NOT NULL, beneficiary VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, date_operation DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FB12895E3363263E (amo_cfg_category_operation_id), UNIQUE INDEX UNIQ_FB12895E919C5715 (amo_cfg_type_operation_id), UNIQUE INDEX UNIQ_FB12895E40D740EF (amo_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_operation_manual (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', amo_cfg_category_operation_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', amo_cfg_type_operation_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', amo_account_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', beneficiary VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, date_operation DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D0B5423363263E (amo_cfg_category_operation_id), UNIQUE INDEX UNIQ_5D0B542919C5715 (amo_cfg_type_operation_id), UNIQUE INDEX UNIQ_5D0B54240D740EF (amo_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_operation_auto ADD CONSTRAINT FK_FB12895E3363263E FOREIGN KEY (amo_cfg_category_operation_id) REFERENCES amo_cfg_category_operation (id)');
        $this->addSql('ALTER TABLE amo_operation_auto ADD CONSTRAINT FK_FB12895E919C5715 FOREIGN KEY (amo_cfg_type_operation_id) REFERENCES amo_cfg_type_operation (id)');
        $this->addSql('ALTER TABLE amo_operation_auto ADD CONSTRAINT FK_FB12895E40D740EF FOREIGN KEY (amo_account_id) REFERENCES amo_account (id)');
        $this->addSql('ALTER TABLE amo_operation_manual ADD CONSTRAINT FK_5D0B5423363263E FOREIGN KEY (amo_cfg_category_operation_id) REFERENCES amo_cfg_category_operation (id)');
        $this->addSql('ALTER TABLE amo_operation_manual ADD CONSTRAINT FK_5D0B542919C5715 FOREIGN KEY (amo_cfg_type_operation_id) REFERENCES amo_cfg_type_operation (id)');
        $this->addSql('ALTER TABLE amo_operation_manual ADD CONSTRAINT FK_5D0B54240D740EF FOREIGN KEY (amo_account_id) REFERENCES amo_account (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amo_operation_auto');
        $this->addSql('DROP TABLE amo_operation_manual');
    }
}
