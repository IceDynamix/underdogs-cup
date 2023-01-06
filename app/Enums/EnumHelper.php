<?php

namespace App\Enums;

enum EnumHelper
{
    public static function enumToArray($cases)
    {
        $arr = [];
        foreach ($cases as $case) {
            $arr[$case->value] = $case->name;
        }

        return $arr;
    }
}
