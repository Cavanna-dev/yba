<?php

abstract class Model
{

    private static $bdd;

    protected function exec($sql, $params = null)
    {
        if ($params == null) {
            $result = $this->getBdd()->query($sql);
        } else {
            $result = $this->getBdd()->prepare($sql);
            $result->execute($params);
        }
        return $result;
    }

    private static function getBdd()
    {
        if (self::$bdd === null) {
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $mdp = Configuration::get("mdp");

            self::$bdd = new PDO($dsn, $login, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$bdd;
    }

}
