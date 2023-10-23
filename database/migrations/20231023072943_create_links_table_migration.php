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
            ->addColumn('original', 'text')
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('domain_id', 'integer', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('short', Index::TYPE_UNIQUE)
            ->addForeignKey('user_id', 'users', 'id', 'cascade')
            ->addForeignKey('domain_id', 'domains', 'id', 'cascade')
            ->create();

    }

    protected function down(): void
    {
        $this->delete('links');
    }
}
