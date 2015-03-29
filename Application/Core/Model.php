<?php
class Model
{
    protected $_dbHandler;
    protected $_viewData = array();

    public function __construct()
    {
        try {
            $this->_dbHandler = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
            if (is_null($this->_dbHandler)) {
                throw new PDOException('Can not connect to database');
            }
        } catch (PDOException $e) {
            echo "Model/__construct is error because " . $e->getMessage();
            die();
        }
    }

    public function setViewData($key,$value)
    {
        if (is_null($key) || is_null($value)) {
            throw new Exception('Model can not set view data with key= ' . $key . ' and data= ' . $value);
        }

        $this->_viewData["$key"] = $value;
    }

    public function getViewDataArray()
    {
        return $this->_viewData;
    }
}