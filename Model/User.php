<?php

require_once 'Core' . DIRECTORY_SEPARATOR . 'Model.php';

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
        $sql = "SELECT *
            FROM users WHERE login=?";
        $userExist = $this->exec($sql, array($login));
        $user = $userExist->fetch(PDO::FETCH_OBJ);

        if (password_verify($pass, $user->pwd) && $userExist->rowCount() == 1)
            return $user;
        else
            throw new Exception("Model/User.php : User $login not found");
    }

    public function getUsers()
    {
        $sql = "SELECT *
            FROM users";
        $req = $this->exec($sql);
        $users = $req->fetchAll(PDO::FETCH_OBJ);

        if ($req->rowCount() > 0)
            return $users;
        else
            throw new Exception("Model/User.php : 0 Users");
    }

    private function getHashedPassword($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function getLastConnectedUsers()
    {
        $sql = "SELECT login, CASE WHEN (now() - last_connected) < 300 THEN 'true' ELSE 'false' END AS online FROM users ORDER BY online DESC";
        $req = $this->exec($sql);
        $users = $req->fetchAll(PDO::FETCH_OBJ);

        if ($req->rowCount() > 0)
            return $users;
        else
            throw new Exception("Model/User.php : 0 Users");
    }

}
