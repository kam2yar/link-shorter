<?php

declare(strict_types=1);

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

final class CreateDomainsTableMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('domains')
            ->addColumn('domain', 'string')
            ->addColumn('active', 'boolean', ['default' => 1])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('domain', Index::TYPE_UNIQUE)
            ->create();
    }

    protected function down(): void
    {
        $this->delete('domains');
    }
}
