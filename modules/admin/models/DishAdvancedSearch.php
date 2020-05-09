<?php


namespace app\modules\admin\models;


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

        $dishes = Dish::find()
            ->innerJoinWith('ingredients')
            ->andWhere(['in', 'dish.id', $activeDishesQuery])
            ->andWhere(['ingredient.id' => $this->_ingredients])
            ->groupBy('dish.id')
            ->having('COUNT(*) >= :countIngredient')
            ->addParams([':countIngredient' => $countIngredient])
            ->asArray()
            ->all();

        // agar to'liq sovpadenie topilmasa chastichniy (2) query qilamiz
        if (!$dishes) {
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