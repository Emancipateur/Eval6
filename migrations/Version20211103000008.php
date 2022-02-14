<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create planque table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('planque');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('nom_code', 'string');
        $table->addColumn('adresse', 'string');
        $table->addColumn('type_id', 'integer');
        $table->addColumn('nationalite_id', 'integer');

        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('type_planque', ['type_id'], ['id']);
        $table->addForeignKeyConstraint('nationalite', ['nationalite_id'], ['id']);
        //$table->addUniqueIndex(['nom_code']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('planque');
    }
}
