<?php

require_once 'Config.php';
require_once 'Request.php';
require_once 'View.php';

abstract class Controller
{

    private $action;
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $controllerClass = get_class($this);
            $this->index();
            throw new Exception("Core/Controller : Action '$action' not defined in $controllerClass");
        }
    }

    public abstract function index();

    protected function generateView($viewData = array(), $action = null)
    {
        $actionView = $this->action;
        if ($action != null) {
            $actionView = $action;
        }

        $controllerClass = get_class($this);
        $controllerView = str_replace("Controller", "", $controllerClass);

        $view = new View($actionView, $controllerView);
        $view->generate($viewData);
    }

    protected function redirect($controller, $action = null)
    {
        $webRoot = Configuration::get("webRoot", "/");
        header("Location:" . $webRoot . $controller . "/" . $action);
    }

}
