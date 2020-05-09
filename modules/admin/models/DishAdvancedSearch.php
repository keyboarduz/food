<?php


namespace app\modules\admin\models;

use Yii;


class DishAdvancedSearch extends Dish
{
    const SEARCH_INIT_STATUS = 0;
    const SEARCH_FULL_MATCH_STATUS = 1;
    const SEARCH_PARTIAL_MATCH_STATUS = 2;
    const SEARCH_NOT_FOUND_MATCH_STATUS = 3;

    private $_searchStatus = 0;

    public function rules()
    {
        $rules[] = parent::rules()['ingredients'];
//        $rules[] = parent::rules()['ingredients_required'];
        return $rules;
    }


    /**
     * @param $params
     * @return array
     */
    public function search($params) {

        if (!$params) {
            return [];
        }

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

        $this->_searchStatus = self::SEARCH_FULL_MATCH_STATUS;

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

            $this->_searchStatus = self::SEARCH_PARTIAL_MATCH_STATUS;
        }

        if (!$dishes) {
            $this->_searchStatus = self::SEARCH_NOT_FOUND_MATCH_STATUS;
        }

        return $dishes;
    }


    /**
     * @return int
     */
    public function getSearchStatus() {
        return $this->_searchStatus;
    }
}