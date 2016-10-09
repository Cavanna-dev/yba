<?php

class Configuration
{

    private static $params;

    public static function get($name, $defaultValue = null)
    {
        $params = self::getParams();
        if (isset($params[$name])) {
            $value = $params[$name];
        } else {
            $value = $defaultValue;
        }
        return $value;
    }

    private static function getParams()
    {
        if (self::$params == null) {
            $urlFile = 'config'.DIRECTORY_SEPARATOR.'config.ini';

            if (!file_exists($urlFile)) {
                throw new Exception("No config file found");
            } else {
                self::$params = parse_ini_file($urlFile);
            }
        }
        return self::$params;
    }

}
