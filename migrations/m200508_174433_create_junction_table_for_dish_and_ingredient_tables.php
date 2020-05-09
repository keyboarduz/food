<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dish_ingredient}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%dish}}`
 * - `{{%ingredient}}`
 */
class m200508_174433_create_junction_table_for_dish_and_ingredient_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dish_ingredient}}', [
            'dish_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
            'PRIMARY KEY(dish_id, ingredient_id)',
        ]);

        // creates index for column `dish_id`
        $this->createIndex(
            '{{%idx-dish_ingredient-dish_id}}',
            '{{%dish_ingredient}}',
            'dish_id'
        );

        // add foreign key for table `{{%dish}}`
        $this->addForeignKey(
            '{{%fk-dish_ingredient-dish_id}}',
            '{{%dish_ingredient}}',
            'dish_id',
            '{{%dish}}',
            'id',
            'CASCADE'
        );

        // creates index for column `ingredient_id`
        $this->createIndex(
            '{{%idx-dish_ingredient-ingredient_id}}',
            '{{%dish_ingredient}}',
            'ingredient_id'
        );

        // add foreign key for table `{{%ingredient}}`
        $this->addForeignKey(
            '{{%fk-dish_ingredient-ingredient_id}}',
            '{{%dish_ingredient}}',
            'ingredient_id',
            '{{%ingredient}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%dish}}`
        $this->dropForeignKey(
            '{{%fk-dish_ingredient-dish_id}}',
            '{{%dish_ingredient}}'
        );

        // drops index for column `dish_id`
        $this->dropIndex(
            '{{%idx-dish_ingredient-dish_id}}',
            '{{%dish_ingredient}}'
        );

        // drops foreign key for table `{{%ingredient}}`
        $this->dropForeignKey(
            '{{%fk-dish_ingredient-ingredient_id}}',
            '{{%dish_ingredient}}'
        );

        // drops index for column `ingredient_id`
        $this->dropIndex(
            '{{%idx-dish_ingredient-ingredient_id}}',
            '{{%dish_ingredient}}'
        );

        $this->dropTable('{{%dish_ingredient}}');
    }
}
