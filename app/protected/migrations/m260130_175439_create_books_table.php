<?php

class m260130_175439_create_books_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('books', array(
            'id' => 'pk',
            'title' => 'varchar(255) NOT NULL',
            'year' => 'smallint(4) NOT NULL',
            'description' => 'text',
            'isbn' => 'varchar(20) NOT NULL',
            'photo' => 'varchar(255)',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));

        $this->createIndex('idx_isbn', 'books', 'isbn', true);
        $this->createIndex('idx_year', 'books', 'year');
    }

    public function down(): void
    {
        $this->dropTable('books');
    }
}
