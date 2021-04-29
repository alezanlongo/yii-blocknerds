<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_collection}}`.
 */
class m210421_020216_add_date_columns_to_user_collection_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user_collection}}', 'created_at', $this->integer()->notNull());
        $this->addColumn('{{%user_collection}}', 'updated_at', $this->integer()->notNull());
        $this->createIndex(
                '{{%idx-user_collection-updated_at}}',
                '{{%user_collection}}',
                'updated_at'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex('{{%idx-user_collection-updated_at}}', '{{%user_collection}}');
        $this->dropColumn('{{%user_collection}}', 'created_at');
        $this->dropColumn('{{%user_collection}}', 'updated_at');
        ;
    }
}
