<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create agent table';
    }

    public function isTransactional(): bool
    {
        return false;
    }
    
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('agent');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('nom', 'string');
        $table->addColumn('prenom', 'string');
        $table->addColumn('date_naissance', 'date');
        $table->addColumn('nom_code', 'string');
        $table->addColumn('nationalite_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('nationalite', ['nationalite_id'], ['id']);
        //$table->addUniqueIndex(['nom_code']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('agent');
    }
}
