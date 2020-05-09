<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "dish".
 *
 * @property int $id
 * @property string $name
 *
 * @property DishIngredient[] $dishIngredients
 * @property Ingredient[] $ingredients
 */
class Dish extends \yii\db\ActiveRecord
{
    public $_ingredients;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            'ingredients' => ['_ingredients', 'validateIngredients', 'skipOnEmpty' => false],

            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    public function validateIngredients($attribute, $params) {
        if (is_countable($this->$attribute)) {
            foreach ($this->$attribute as $ingredient) {
                if (!is_numeric($ingredient)) {
                    $this->addError($attribute, 'data not valid!');
                    return;
                }
            }
        } else {
            $this->addError($attribute, 'Выберите больше ингредиентов!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            '_ingredients' => 'Ингредиенты'
        ];
    }

    /**
     * Gets query for [[DishIngredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDishIngredients()
    {
        return $this->hasMany(DishIngredient::className(), ['dish_id' => 'id']);
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])->viaTable('dish_ingredient', ['dish_id' => 'id']);
    }

    public function saveWithIngredients()
    {
       $transaction = static::getDb()->beginTransaction();

       try {
           // hamma ingredientlarni o'chirish
           $this->unlinkAll('ingredients', true);

           if (!$this->save(false)) {
               throw new Exception('dish not saved!');
           }

           // hamma ingredientlarni saqlash
           foreach ($this->_ingredients as $ingredient) {
               $ingredient = Ingredient::findONe(['id' => $ingredient]);
               $this->link('ingredients', $ingredient);
           }

           $transaction->commit();
       } catch (\Exception $e) {
           $transaction->rollBack();
           Yii::error($e->getMessage());
           return false;
       } catch (\Throwable $e) {
           $transaction->rollBack();
           Yii::error($e->getMessage());
           return false;
       }

       return true;
    }

    public function deleteWithIngredients()
    {
        $transaction = static::getDb()->beginTransaction();

        try {
            // hamma ingredientlarni o'chirish
            $this->unlinkAll('ingredients', true);

            if (!$this->delete()) {
                throw new Exception('dish not deleted!');
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage());
            return false;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage());
            return false;
        }

        return true;
    }
}
