<?php

class Controller
{

    public $vars = array();
    public $layout = 'default';

    final public function render($filename)
    {
        extract($this->vars);
        require(ROOT . '/views/' . get_class($this) . '/' . $filename . '.php');
        $contentForLayout = ob_get_clean();
        
        if ($this->layout == false) {
            echo $contentForLayout;
        } else {
            require(ROOT . '/views/layout/' . $this->layout . '.php');
        }
    }

    final public function set($d)
    {
        $this->vars = array_merge($this->vars, $d);
    }

}
