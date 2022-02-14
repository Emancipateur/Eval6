<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create nationalite table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('nationalite');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('pays', 'string');
        $table->addColumn('nationalite', 'string');
        $table->addColumn('code', 'string');

        $table->setPrimaryKey(['id']);
        //$table->addUniqueIndex(['pays']);
        //$table->addUniqueIndex(['nationalite']);
        //$table->addUniqueIndex(['code']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('nationalite');
    }
}
