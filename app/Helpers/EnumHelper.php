<?php

namespace App\Helpers;

class EnumHelper
{
    public static function enumToArray(string $enumClass): array
    {
        $enumArray = [];

        $constants = $enumClass::cases();

        foreach ($constants as $value) {
            $name = ucwords(str_replace('_', ' ', strtolower($value->name)));
            $enumArray[$name] = intval($value->value);
        }

        return $enumArray;
    }
}