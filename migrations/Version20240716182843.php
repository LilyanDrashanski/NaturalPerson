<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716182843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE natural_person DROP token');
        $this->addSql('ALTER TABLE natural_person ALTER id DROP DEFAULT');
    }

//    public function down(Schema $schema): void
//    {
//        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE SCHEMA public');
//        $this->addSql('ALTER TABLE natural_person ADD token UUID DEFAULT \'uuid_generate_v4()\' NOT NULL');
//        $this->addSql('CREATE SEQUENCE natural_person_id_seq');
//        $this->addSql('SELECT setval(\'natural_person_id_seq\', (SELECT MAX(id) FROM natural_person))');
//        $this->addSql('ALTER TABLE natural_person ALTER id SET DEFAULT nextval(\'natural_person_id_seq\')');
//        $this->addSql('CREATE UNIQUE INDEX natural_person_pk ON natural_person (token)');
//        $this->addSql('CREATE UNIQUE INDEX natural_person_pk_2 ON natural_person (token)');
//    }
}
