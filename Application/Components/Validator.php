<?php

namespace Application\Components;

class Validator
{
    public static function validateEmpty($arr)
    {
        foreach ($arr as $item){
            if (empty($item) && $item!==0){
                return false;
            }
        }
        return true;
    }
}