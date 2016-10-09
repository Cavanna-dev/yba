<?php

class Session
{

    public function __construct()
    {
        session_start();
    }

    public function destroy()
    {
        session_destroy();
    }

    public function setAttribute($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function existAttribute($name)
    {
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }

    public function getAttribute($name)
    {
        if ($this->existAttribute($name)) {
            return $_SESSION[$name];
        } else {
            throw new Exception("Attribute '$name' doesn't existF");
        }
    }

}
