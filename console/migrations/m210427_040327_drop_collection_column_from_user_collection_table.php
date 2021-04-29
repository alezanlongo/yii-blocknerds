<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user_collection}}`.
 */
class m210427_040327_drop_collection_column_from_user_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user_collection}}', 'collection');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user_collection}}', 'collection', $this->json());
    }
}
