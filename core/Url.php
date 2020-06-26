<?php

namespace Core;

class Url
{
    public static function getRootUrl()
    {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    }

    public static function generate(string $relative_url, array $params)
    {
        $query = http_build_query($params);
        return self::getRootUrl() . $relative_url . '?' . $query;
    }
}