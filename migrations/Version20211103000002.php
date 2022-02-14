<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create specialite table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('specialite');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('nom', 'string');
      
        $table->setPrimaryKey(['id']);
        //$table->addUniqueIndex(['nom']);
      }

    public function down(Schema $schema): void
    {
        $schema->dropTable('specialite');
    }
}
