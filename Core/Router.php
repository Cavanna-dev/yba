<?php

require_once 'Request.php';
require_once 'View.php';

class Router
{

    public function routerRequest()
    {
        try {
            $request = new Request(array_merge($_GET, $_POST));
            $controleur = $this->createController($request);
            $action = $this->createAction($request);
            $controleur->executeAction($action);
        } catch (Exception $e) {
            $this->manageError($e);
        }
    }

    private function createController(Request $request)
    {
        $controller = "Home";  // Contrôleur par défaut
        if ($request->existParam('controller')) {
            $controller = $request->getParametre('controller');
            $controller = ucfirst(strtolower($controller));
        }

        $controllerClass = $controller . "Controller";
        $controllerFile = "Controller/" . $controllerClass . ".php";
        if (file_exists($controllerFile)) {
            require($controllerFile);
            $controller = new $controllerClass();
            $controller->setRequest($request);
            return $controller;
        } else {
            throw new Exception("Router.php : File '$controllerFile' not found");
        }
    }

    private function createAction(Request $request)
    {
        $action = "index";  // Action par défaut
        if ($request->existParam('action')) {
            $action = $request->getParam('action');
        }
        return $action;
    }

    private function manageError(Exception $exception)
    {
        $vue = new View('error');
        $vue->generate(array('errorMsg' => $exception->getMessage()));
    }

}
