<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210429_173957_add_role_column_to_user_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user}}', 'role', $this->integer()->defaultValue(10)->after('staus'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%user}}', 'role');
    }

}
