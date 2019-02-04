<?php

declare(strict_types=1);

namespace App\Domain\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204162025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX UNIQ_5D0B5423363263E, ADD INDEX IDX_5D0B5423363263E (amo_cfg_category_operation_id)');
        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX UNIQ_5D0B54240D740EF, ADD INDEX IDX_5D0B54240D740EF (amo_account_id)');
        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX UNIQ_5D0B542919C5715, ADD INDEX IDX_5D0B542919C5715 (amo_cfg_type_operation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX IDX_5D0B5423363263E, ADD UNIQUE INDEX UNIQ_5D0B5423363263E (amo_cfg_category_operation_id)');
        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX IDX_5D0B542919C5715, ADD UNIQUE INDEX UNIQ_5D0B542919C5715 (amo_cfg_type_operation_id)');
        $this->addSql('ALTER TABLE amo_operation_manual DROP INDEX IDX_5D0B54240D740EF, ADD UNIQUE INDEX UNIQ_5D0B54240D740EF (amo_account_id)');
    }
}
