<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create mission table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('mission');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('titre', 'string');
        $table->addColumn('description', 'text');
        $table->addColumn('nom_code', 'string');
        $table->addColumn('date_debut', 'datetime');
        $table->addColumn('date_fin', 'datetime');
        $table->addColumn('specialite_id', 'integer');
        $table->addColumn('statut_id', 'integer');
        $table->addColumn('type_id', 'integer');
        $table->addColumn('nationalite_id', 'integer');
        
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('specialite', ['specialite_id'], ['id']);
        $table->addForeignKeyConstraint('statut_mission', ['statut_id'], ['id']);
        $table->addForeignKeyConstraint('type_mission', ['type_id'], ['id']);
        $table->addForeignKeyConstraint('nationalite', ['nationalite_id'], ['id']);
        //$table->addUniqueIndex(['nom_code']);

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('mission');
    }
}
