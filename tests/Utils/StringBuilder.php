<?php

class StringBuilder
{
    public static function createStringWithNumberOfSymbols(int $number)
    {
        $string = '';

        for ($i = 0; $i < $number; $i++) {
            $string .= 'a';
        }

        return $string;
    }
}
