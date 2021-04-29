<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_collection}}`.
 */
class m210427_002732_add_name_column_to_user_collection_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user_collection}}', 'name', $this->string(150)->after('user_id'));
        $this->createIndex(
                '{{%idx-user_collection-name}}',
                '{{%user_collection}}',
                'name'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropIndex('{{%idx-user_collection-name}}', '{{%user_collection}}');
        $this->dropColumn('{{%user_collection}}', 'name');
    }

}
