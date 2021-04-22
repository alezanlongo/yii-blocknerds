<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_collection}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210421_014919_create_user_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_collection}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'collection' => $this->json(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_collection-user_id}}',
            '{{%user_collection}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_collection-user_id}}',
            '{{%user_collection}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_collection-user_id}}',
            '{{%user_collection}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_collection-user_id}}',
            '{{%user_collection}}'
        );

        $this->dropTable('{{%user_collection}}');
    }
}
