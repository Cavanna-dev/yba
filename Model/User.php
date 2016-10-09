<?php

require_once 'Core/Model.php';

class User extends Model
{

    public function login($login, $pass)
    {

        $sql = "SELECT id, pwd FROM users WHERE login=?";
        $userExist = $this->exec($sql, array($login));

        if ($userExist->rowCount() == 1) {
            $user = $userExist->fetch(PDO::FETCH_OBJ);
            return password_verify($pass, $user->pwd);
        } else {
            $sql = 'INSERT INTO users(login, pwd)'
                    . ' values(?, ?)';

            $passwordHashed = $this->getHashedPassword($pass);
            $user = $this->exec($sql, array($login, $passwordHashed));

            return $user ? true : false;
        }
    }

    public function getUser($login, $pass)
    {
        $passwordHashed = $this->getHashedPassword($pass);

        $sql = "SELECT id, login 
            FROM users WHERE login=? and pwd=?";
        $user = $this->exec($sql, array($login, $passwordHashed));

        if ($user->rowCount() == 1)
            return $user->fetch();
        else
            throw new Exception("Model/User.php : User $login not found");
    }

    private function getHashedPassword($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

}
