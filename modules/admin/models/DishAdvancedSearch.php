<?php


namespace app\modules\admin\models;

use Yii;


class DishAdvancedSearch extends Dish
{
    public function rules()
    {
        $rules[] = parent::rules()['ingredients'];
        return $rules;
    }


    /**
     * @param $params
     * @return array
     */
    public function search($params) {

        $this->load($params);

        if (! $this->validate('_ingredients')) {
            return [];
        }

        $countIngredient = count($this->_ingredients);

        $activeDishesQuery = Dish::find()
            ->select('dish.id')
            ->innerJoinWith('ingredients')
            ->groupBy('dish.id')
            ->having('COUNT(*) = SUM(ingredient.status)');

        $allIngredientsByDishQuery = Dish::find()
            ->select('COUNT(*) AS sum2, dish.*')
            ->innerJoinWith('ingredients')
            ->groupBy('dish.id');

        // Если найдены блюда с полным совпадением ингредиентов ­ вывести
        //только их.
        $dishes = Dish::find()
            ->select('COUNT(*) AS sum1, dish.*, allIngByDish.sum2 AS sum22')
            ->innerJoinWith('ingredients')
            ->innerJoin(['allIngByDish' => $allIngredientsByDishQuery], 'allIngByDish.id = dish.id')
            ->andWhere(['in', 'dish.id', $activeDishesQuery])
            ->andWhere(['ingredient.id' => $this->_ingredients])
            ->groupBy('dish.id')
            ->having('sum1 = :countIngredient AND sum22 = sum1')
            ->addParams([':countIngredient' => $countIngredient])
            ->asArray()
            ->all();

        // agar to'liq sovpadenie topilmasa chastichniy (2) query qilamiz
        if (!$dishes) {
            Yii::debug('second query');
            $dishes = Dish::find()
                ->select('dish.*, COUNT(*) AS count_ingredient')
                ->innerJoinWith('ingredients')
                ->andWhere(['in', 'dish.id', $activeDishesQuery])
                ->andWhere(['ingredient.id' => $this->_ingredients])
                ->groupBy('dish.id')
                ->having('COUNT(*) >= 2')
                ->orderBy('count_ingredient DESC')
                ->asArray()
                ->all();
        }

        return $dishes;
    }
}