<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626183016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD token VARCHAR(32) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B723AF335F37A13B ON student (token)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher ADD token VARCHAR(32) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B0F6A6D55F37A13B ON teacher (token)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_B723AF335F37A13B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP token
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_B0F6A6D55F37A13B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher DROP token
        SQL);
    }
}
