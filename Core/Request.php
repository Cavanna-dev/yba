<?php

require_once 'Session.php';

class Request
{

    private $params;
    private $session;

    public function __construct($params)
    {
        $this->params = $params;
        $this->session = new Session();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function existParam($name)
    {
        return (isset($this->params[$name]) && $this->params[$name] != "");
    }

    public function getParam($name)
    {
        if ($this->existParam($name)) {
            return $this->params[$name];
        } else {
            throw new Exception("Param '$name' doesn't exist");
        }
    }

}
