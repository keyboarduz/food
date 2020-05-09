<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 *
 * @property DishIngredient[] $dishIngredients
 * @property Dish[] $dishes
 */
class Ingredient extends \yii\db\ActiveRecord
{
    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['name'], 'string'],
            ['status', 'in', 'range' => [self::STATUS_HIDE, self::STATUS_SHOW]]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[DishIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishIngredients()
    {
        return $this->hasMany(DishIngredient::className(), ['ingredient_id' => 'id']);
    }

    /**
     * Gets query for [[Dishes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['id' => 'dish_id'])->viaTable('dish_ingredient', ['ingredient_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getIngredientsAsArray() {
        $ingredients = static::find()
            ->where(['status' => self::STATUS_SHOW])
            ->asArray()
            ->all();



        return ArrayHelper::map($ingredients, 'id', 'name');
    }
}
