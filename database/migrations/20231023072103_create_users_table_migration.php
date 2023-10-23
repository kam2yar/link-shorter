<?php

declare(strict_types=1);

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

final class CreateUsersTableMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('users')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addIndex('email', Index::TYPE_UNIQUE)
            ->create();
    }

    protected function down(): void
    {
        $this->delete('users');
    }
}
