<?php

class m260130_175524_create_book_authors_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('book_authors', [
            'book_id' => 'int(11) NOT NULL',
            'author_id' => 'int(11) NOT NULL',
            'PRIMARY KEY (book_id, author_id)',
        ]);

        $this->addForeignKey('fk_book_authors_book', 'book_authors', 'book_id', 'books', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_book_authors_author', 'book_authors', 'author_id', 'authors', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_author_id', 'book_authors', 'author_id');
    }

    public function down(): void
    {
        $this->dropTable('book_authors');
    }
}
