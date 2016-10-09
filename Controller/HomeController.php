<?php

require_once 'Core' . DIRECTORY_SEPARATOR . 'View.php';
require_once 'Core' . DIRECTORY_SEPARATOR . 'Controller.php';
require_once 'Model' . DIRECTORY_SEPARATOR . 'User.php';
require_once 'Model' . DIRECTORY_SEPARATOR . 'Message.php';

class HomeController extends \Controller
{

    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->message = new Message();
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
                $user = $this->user->getUser($login, $pass);
                $this->request->getSession()->setAttribute("userId", $user->id);
                $this->request->getSession()->setAttribute("userLogin", $user->login);
                $this->redirect("home", "chat");
            } else {
                $this->generateView(array('errorMsg' => 'Couple Login/mot de passe incorrect'), "index");
            }
        } else {
            throw new Exception("Action impossible : Vous devez entrer un login/mot de passe pour vous connectez");
        }
    }

    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->generateView(array('errorMsg' => 'Votre session est fermée'), "index");
    }

    public function chat()
    {
        if ($this->request->getSession()->existAttribute("userId")) {
            $messages = $this->message->getMessages();
            $lastMessage = $this->message->getLastMessage();
            $users = $this->user->getLastConnectedUsers();

            $this->generateView(array('users' => $users, 'messages' => $messages, 'lastId' => $lastMessage->id));
        } else {
            $this->generateView(array('errorMsg' => 'Vous devez etre connecter'), "index");
        }
    }

    public function addMessage()
    {
        if ($this->request->getSession()->existAttribute("userId")) {
            if ($this->request->existParam("message")) {
                $userId = $this->request->getSession()->getAttribute("userId");
                $this->message->addMessage($userId, $this->request->getParam("message"));
                $lastMessage = $this->message->getLastMessage();

                $content = '<div class="media msg"><div class="media-body"><small class="pull-right time"><i class="fa fa-clock-o"></i> ' . $lastMessage->date . '</small><h5 class="media-heading">' . $lastMessage->login . '</h5><small class="col-lg-10">' . $lastMessage->message . '</small></div></div>';
                $lastId = $lastMessage->id;

                $r = array(
                    'content' => $content,
                    'lastId' => $lastId
                );
                echo json_encode($r);
            }
        } else {
            $this->generateView(array('errorMsg' => 'Vous devez etre connecter'), "index");
        }
    }

    public function getLastMessages()
    {
        if ($this->request->getSession()->existAttribute("userId")) {
            if ($this->request->existParam("lastId") && $this->request->getParam("lastId") != 0) {
                $lastId = $this->request->getParam("lastId");
                $messages = $this->message->getLastMessages($lastId);

                $content = '';
                $lastId = 0;
                foreach ($messages as $message) {
                    $content .= '<div class="media msg"><div class="media-body"><small class="pull-right time"><i class="fa fa-clock-o"></i> ' . $message->date . '</small><h5 class="media-heading">' . $message->login . '</h5><small class="col-lg-10">' . $message->message . '</small></div></div>';
                    $lastId = $message->id;
                }

                $r = array(
                    'content' => $content,
                    'lastId' => $lastId
                );
                echo json_encode($r);
            }
        } else {
            $this->generateView(array('errorMsg' => 'Vous devez etre connecter'), "index");
        }
    }

    public function getLastConnectedUsers()
    {
        if ($this->request->getSession()->existAttribute("userId")) {

            $users = $this->user->getLastConnectedUsers();

            $content = '';
            foreach ($users as $user) {
                $online = $user->online == "true" ? "En ligne" : "Hors ligne";
                $content .= '<div class="media conversation"><div class="media-body"><h5 class="media-heading">'.$user->login.'</h5><small>'. $online .'</small></div></div>';
            }
            
            echo json_encode($content);
        } else {
            $this->generateView(array('errorMsg' => 'Vous devez etre connecter'), "index");
        }
    }

}
