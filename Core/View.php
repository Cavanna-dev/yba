<?php

require_once 'Configuration.php';

class View
{

    private $file;

    public function __construct($action, $controller = "")
    {
        $file = "View/";
        if ($controller != "") {
            $file = $file . $controller . "/";
        }
        $this->file = $file . $action . ".php";
    }

    public function generate($data)
    {
        $content = $this->generateFile($this->file, $data);
        $webRoot = Configuration::get("webRoot", "/");
        $view = $this->generateFile('View/default.php', array('content' => $content, 'webRoot' => $webRoot));

        echo $view;
    }

    private function generateFile($file, $data)
    {
        if (file_exists($file)) {
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Core/View.php : File '$file' not found");
        }
    }

    private function clean($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

}
