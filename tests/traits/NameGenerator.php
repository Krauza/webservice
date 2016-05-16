<?php

trait NameGenerator
{
    public static function correct($min = 0)
    {
        return self::create($min, $min);
    }

    public static function greaterThan($max)
    {
        return self::create(0, $max);
    }

    private static function create($min = 0, $max = 0)
    {
        $name = '';
        for($i = $min; $i <= $max; $i++) {
            $name .= 'a';
        }

        return $name;
    }
}
