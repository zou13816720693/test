<?php

namespace App\Consts\Common;

/**
 * 流水类型
 * @author: zouxiang
 * @date:
 */
class AccountFlowTypeConst
{
    const PAYMENT = 1;
    const RECHARGE = 2;
    const HEDGING = 3;
    const REFUND = 4;

    const PAYMENT_DESC = '支付';
    const RECHARGE_DESC = '充值';
    const HEDGING_DESC = '对冲';
    const REFUND_DESC = '退款';

    public static function desc()
    {
        return [
            self::PAYMENT => self::PAYMENT_DESC,
            self::RECHARGE => self::RECHARGE_DESC,
            self::HEDGING => self::HEDGING_DESC,
            self::REFUND => self::REFUND_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

    public static function getIconDesc($item)
    {
        $array = [
            self::PAYMENT => '-',
            self::RECHARGE => '+',
            self::HEDGING => '-',
            self::REFUND => '+',
        ];
        return array_get($array, $item);
    }
}