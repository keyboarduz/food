<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ingredient}}`.
 */
class m200508_204415_add_status_column_to_ingredient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%ingredient}}', 'status', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%ingredient}}');
    }
}
