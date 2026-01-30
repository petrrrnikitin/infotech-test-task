<?php

class m260130_195019_create_users_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('users', [
            'id' => 'pk',
            'username' => 'varchar(255) NOT NULL',
            'password_hash' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255)',
            'role' => "enum('user') NOT NULL DEFAULT 'user'",
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex('idx_username', 'users', 'username', true);
        $this->createIndex('idx_email', 'users', 'email', true);
    }

    public function down(): void
    {
        $this->dropTable('users');
    }
}
