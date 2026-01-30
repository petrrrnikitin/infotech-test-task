<?php

class m260130_175503_create_authors_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('authors', [
            'id' => 'pk',
            'first_name' => 'varchar(100) NOT NULL',
            'last_name' => 'varchar(100) NOT NULL',
            'middle_name' => 'varchar(100)',
        ]);

        $this->createIndex('idx_name', 'authors', 'last_name, first_name');
    }

    public function down(): void
    {
        $this->dropTable('authors');
    }
}
