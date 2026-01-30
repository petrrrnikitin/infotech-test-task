<?php

class m260130_175748_create_subscriptions_table extends CDbMigration
{
    public function up(): void
    {
        $this->createTable('subscriptions', array(
            'id' => 'pk',
            'author_id' => 'int(11) NOT NULL',
            'phone' => 'varchar(20) NOT NULL',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));

        $this->createIndex('idx_author_phone', 'subscriptions', 'author_id, phone', true);
        $this->createIndex('idx_author_id', 'subscriptions', 'author_id');
    }

    public function down(): void
    {
        $this->dropTable('subscriptions');
    }
}
