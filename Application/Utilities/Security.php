<?php

class Security
{
    const SALT_HASHING = '$mywebsite$(#*@)**#';

    public static function hashing($str)
    {
        if (!isset($str)) {
            return false;
        }

        return md5(self::SALT_HASHING . $str);
    }
}