<?php

require_once 'Core'.DIRECTORY_SEPARATOR.'View.php';
require_once 'Core'.DIRECTORY_SEPARATOR.'Controller.php';
require_once 'Model'.DIRECTORY_SEPARATOR.'User.php';

class HomeController extends \Controller
{

    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $this->generateView();
    }

    public function login()
    {
        if ($this->request->existParam("userLogin") && $this->request->existParam("userPassword")) {
            $login = $this->request->getParam("userLogin");
            $pass = $this->request->getParam("userPassword");
            if ($this->user->login($login, $pass)) {
                $this->request->getSession()->setAttribute("userId", $login);
                $this->request->getSession()->setAttribute("userLogin", $pass);
                $this->redirect("home", "chat");
            } else {
                $this->generateView(array('errorMsg' => 'Couple Login/mot de passe incorrect'), "index");
            }
        } else {
            throw new Exception("Action impossible : Vous devez entrer un login/mot de passe pour vous connectez");
        }
    }

    public function chat()
    {
        if ($this->request->getSession()->existAttribute("userId")) {
            $this->generateView();
        } else {
            $this->generateView(array('errorMsg' => 'Vous devez etre connecter'), "index");
        }
    }

}
