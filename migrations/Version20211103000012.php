<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create mission_agent table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('mission_agent');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('mission_id', 'integer');
        $table->addColumn('agent_id', 'integer');
        
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('mission', ['mission_id'], ['id']);
        $table->addForeignKeyConstraint('agent', ['agent_id'], ['id']);
        //$table->addUniqueIndex(['mission_id', 'agent_id']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('mission_agent');
    }
}
