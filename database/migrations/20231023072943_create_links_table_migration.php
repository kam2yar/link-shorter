<?php

declare(strict_types=1);

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

final class CreateLinksTableMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('links')
            ->addColumn('short', 'string')
            ->addColumn('long', 'text')
            ->addColumn('user_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addIndex('short', Index::TYPE_UNIQUE)
            ->addForeignKey('user_id', 'users', 'id', 'cascade')
            ->create();

    }

    protected function down(): void
    {
        $this->delete('links');
    }
}
