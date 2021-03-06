<?php
namespace App\Consts\Common;

class MealTypeConst
{
    const MORNING = 1;
    const LUNCH = 2;
    const DINNER = 3;
    const STORE = 4;
    const TAKEOUT = 5;
    const ADMIN_OPERATION = 6;
    const FRESH_TAKEOUT = 7;

    const MORNING_DESC = '早餐';
    const LUNCH_DESC = '午餐';
    const DINNER_DESC = '晚餐';
    const STORE_DESC = '超市';
    const TAKEOUT_DESC = '外卖';
    const ADMIN_OPERATION_DESC = '后台扣款';
    const FRESH_TAKEOUT_DESC = '生鲜外卖';


    public static function desc()
    {
        return [
            self::MORNING => self::MORNING_DESC,
            self::LUNCH => self::LUNCH_DESC,
            self::DINNER => self::DINNER_DESC,
            self::STORE => self::STORE_DESC,
            self::TAKEOUT => self::TAKEOUT_DESC,
            self::ADMIN_OPERATION => self::ADMIN_OPERATION_DESC,
            self::FRESH_TAKEOUT => self::FRESH_TAKEOUT_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

    public static function priceDesc()
    {
        return [
            self::MORNING => config('config.morning_price'),
            self::LUNCH => config('config.lunch_price'),
            self::DINNER => config('config.dinner_price'),
        ];
    }

    public static function getPriceDesc($item)
    {
        return array_get(self::priceDesc(), $item);
    }
}