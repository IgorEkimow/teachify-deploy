<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626085737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX student__login__uniq ON student (login) WHERE (deleted_at IS NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX teacher__login__uniq ON teacher (login) WHERE (deleted_at IS NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX student__login__uniq
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX teacher__login__uniq
        SQL);
    }
}
