<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create mission_cible table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('mission_cible');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('mission_id', 'integer');
        $table->addColumn('cible_id', 'integer');
        
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('mission', ['mission_id'], ['id']);
        $table->addForeignKeyConstraint('cible', ['cible_id'], ['id']);
        //$table->addUniqueIndex(['mission_id', 'cible_id']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('mission_cible');
    }
}
