<?php

class Bootstrap
{
    private $_url;
    private $_controller;
    private $_action;
    private $_params;

    private $_defaultController = 'user';
    private $_defaultAction = 'index';

    private $_errorController = 'error';

    /**
     * Construct Url
     * init session
     * processing url: clean url, sanitize, decompose url to separated elements based on backslash
     */
    public function __construct()
    {
        if (!isset($_GET['url'])){
            $this->_url = null;
        } else {
            $this->_url = $_GET['url'];
            $this->_url = rtrim($this->_url,'/');
            $this->_url = filter_var($this->_url,FILTER_SANITIZE_URL);
            $this->_url = explode('/',$this->_url);
        }
    }

    public function __get($varName)
    {
        return $this->$varName;
    }

    /**
     * _parseRoute parse url to controller, action with params if any
     * If any component is empty, use default options.
     */
    private function _parseRoute()
    {
        if (empty($this->_url)) {
            //default case
            $this->_controller = $this->_defaultController;
            $this->_action = $this->_defaultAction;
            $this->_params = null;
        } else {
            $this->_controller = $this->_url[0];
            //action if any
            if (!isset($this->_url[1])) {
                $this->_action = $this->_defaultAction;
            } else {
                $this->_action = $this->_url[1];
            }

            //params if any
            if (isset($this->_url[2])) {
                $this->_params = array_slice($this->_url,2);
            }
        }
    }

    /**
     * routing  analysing url, load needed classes and forwarding actions to them.
     */
    public function routing()
    {
        $this->_parseRoute();

        //Qui uoc la cac controller luon co them chu Controller
        $controllerFile = CONTROLLER_PATH . '/' . $this->_controller . 'Controller.php';
        if (!file_exists($controllerFile)) {
            $controllerFile = CONTROLLER_PATH . '/' . $this->_errorController . 'Controller.php';
        }
        require_once($controllerFile);

        //Create Object
        $controllerClass = $this->_controller . 'Controller';
        if(!class_exists($controllerClass)) {
            $controllerClass = $this->_errorController . 'Controller';
        }
        $controller = new $controllerClass;

        //call method
        if (!is_callable(array($controller,$this->_action))) {
            $controllerClass = $this->_errorController . 'Controller';
            $controller = new $controllerClass;
            $controller->{$this->_defaultAction}($this->_params);
        } else {
            $controller->{$this->_action}($this->_params);
        }
    }
}
