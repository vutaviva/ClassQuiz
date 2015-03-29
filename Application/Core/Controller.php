<?php

class Controller
{
    protected $_model;
    protected $_view;

    public function __construct()
    {
    }

    //use for unit test
    public function __get($varName)
    {
        return $this->$varName;
    }

    protected function _setModel($modelName)
    {
        if (!class_exists($modelName)) {
            throw new Exception("Controller can not set Model for '" . $modelName . "'");
        } else {
            $this->_model = new $modelName();
        }
    }

    protected function _setView($viewTemplate)
    {
        $this->_view = new View($viewTemplate, $this->_model);
    }
}
