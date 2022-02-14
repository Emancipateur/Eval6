<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211103000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('user');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('email', 'string');
        $table->addColumn('roles', 'text');
        $table->addColumn('password', 'string');

        $table->setPrimaryKey(['id']);
        //$table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
    }
}
