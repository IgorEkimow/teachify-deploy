<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250615204054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE "group" (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(128) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, teacher_id BIGINT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX group_teacher_id_ind ON "group" (teacher_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE group_skills (group_id BIGINT NOT NULL, skill_id BIGINT NOT NULL, PRIMARY KEY(group_id, skill_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6B7CEA0FE54D947 ON group_skills (group_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6B7CEA05585C142 ON group_skills (skill_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE skill (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(128) NOT NULL, login VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, group_id BIGINT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX student_group_id_ind ON student (group_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student_skill (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, priority INT DEFAULT 1 NOT NULL, student_id BIGINT NOT NULL, skill_id BIGINT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX student_skill_student_id_ind ON student_skill (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX student_skill_skill_id_ind ON student_skill (skill_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE teacher (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(128) NOT NULL, login VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE teacher_skill (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, level INT DEFAULT 1 NOT NULL, teacher_id BIGINT NOT NULL, skill_id BIGINT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX teacher_skill_teacher_id_ind ON teacher_skill (teacher_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX teacher_skill_skill_id_ind ON teacher_skill (skill_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "group" ADD CONSTRAINT group_teacher_id__fk FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_skills ADD CONSTRAINT group_skills_group_id__fk FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_skills ADD CONSTRAINT group_skills_skill_id__fk FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD CONSTRAINT student_group_id__fk FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_skill ADD CONSTRAINT student_skill_student_id__fk FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_skill ADD CONSTRAINT student_skill_skill_id__fk FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher_skill ADD CONSTRAINT teacher_skill_teacher_id__fk FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher_skill ADD CONSTRAINT teacher_skill_skill_id__fk FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE "group" DROP CONSTRAINT group_teacher_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_skills DROP CONSTRAINT group_skills_group_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE group_skills DROP CONSTRAINT group_skills_skill_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP CONSTRAINT student_group_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_skill DROP CONSTRAINT student_skill_student_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_skill DROP CONSTRAINT student_skill_skill_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher_skill DROP CONSTRAINT teacher_skill_teacher_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE teacher_skill DROP CONSTRAINT teacher_skill_skill_id__fk
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "group"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE group_skills
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE skill
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student_skill
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE teacher
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE teacher_skill
        SQL);
    }
}