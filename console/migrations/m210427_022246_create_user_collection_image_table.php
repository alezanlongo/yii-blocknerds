<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_collection_image}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user_collection}}`
 */
class m210427_022246_create_user_collection_image_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%user_collection_image}}', [
            'id' => $this->primaryKey(),
            'usercollection_id' => $this->integer()->notNull(),
            'external_image_id' => $this->string(50),
            'title' => $this->string(),
            'thumb_file' => $this->string(),
            'image_file' => $this->string(),
            'position' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
        // creates index for column `usercollection_id`
        $this->createIndex(
                '{{%idx-user_collection_image-usercollection_id}}',
                '{{%user_collection_image}}',
                'usercollection_id',
        );
        $this->createIndex(
                '{{%idx-user_collection_image-external_image_id}}',
                '{{%user_collection_image}}',
                'external_image_id',
        );
        $this->createIndex(
                '{{%idx-user_collection_image-title}}',
                '{{%user_collection_image}}',
                'title',
        );
        $this->createIndex(
                '{{%idx-user_collection_image-position}}',
                '{{%user_collection_image}}',
                'position',
        );
        $this->createIndex(
                '{{%idx-user_collection_image-created_at}}',
                '{{%user_collection_image}}',
                'created_at',
        );
        $this->createIndex(
                '{{%idx-user_collection_image-updated_at}}',
                '{{%user_collection_image}}',
                'updated_at'
        );

        // add foreign key for table `{{%user_collection}}`
        $this->addForeignKey(
                '{{%fk-user_collection_image-usercollection_id}}',
                '{{%user_collection_image}}',
                'usercollection_id',
                '{{%user_collection}}',
                'id',
                'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for table `{{%user_collection}}`
        $this->dropForeignKey(
                '{{%fk-user_collection_image-usercollection_id}}',
                '{{%user_collection_image}}'
        );

        // drops index for column `usercollection_id`
        $this->dropIndex(
                '{{%idx-user_collection_image-usercollection_id}}',
                '{{%user_collection_image}}'
        );

        $this->dropTable('{{%user_collection_image}}');
    }

}
