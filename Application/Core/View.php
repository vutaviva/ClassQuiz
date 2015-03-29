<?php

class View
{
    protected $_model;
    protected $_viewFile;

    public function __construct($templateFile = null, $model = null)
    {
        $this->_viewFile = $templateFile;
        $this->_model = $model;
    }

    public function render()
    {
        if (!file_exists($this->_viewFile)) {
            throw new Exception('View by ' . $this->_viewFile . ' is not exist');
        }

        if (!is_null($this->_model)) {
            extract($this->_model->getViewDataArray());
        }

        ob_start(); //TODO: check for using GZIP compression
        include($this->_viewFile);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

