<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create agent_specialite table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('agent_specialite');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('agent_id', 'integer');
        $table->addColumn('specialite_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('agent', ['agent_id'], ['id']);
        $table->addForeignKeyConstraint('specialite', ['specialite_id'], ['id']);
        //$table->addUniqueIndex(['agent_id', 'specialite_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('agent_specialite');
    }
}
