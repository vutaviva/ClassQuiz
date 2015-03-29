<?php

//TODO: Read more about XSS (Cross-site Scripting)
class CodeInjectionPrevent
{
    public static function sanitizeMySQL($str)
    {
        //Because code use PDO for prepare sql, no need for sanitize SQL
        //Moreover, function mysql_real_escape_string will be deprecated in new version PHP
        //We can prevent HTML Injection
        return CodeInjectionPrevent::sanitizeHTML($str);
    }

    public static function sanitizeHTML($str)
    {
        return htmlentities($str);
    }
}