<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create type_mission table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('type_mission');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('nom', 'string');
        
        $table->setPrimaryKey(['id']);
        //$table->addUniqueIndex(['nom']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('type_mission');
    }
}
