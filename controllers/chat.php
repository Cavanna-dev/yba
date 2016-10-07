<?php

class Chat extends Controller
{

    function index()
    {
        $d = array(
            'author' => 'Cavanna Christophe',
            'message' => 'Coucou'
        );
        $this->set($d);
        $this->render('view');
    }

}
