<?php

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_setView(VIEW_PATH . 'Error/index.php');
        echo $this->_view->render();
    }
}