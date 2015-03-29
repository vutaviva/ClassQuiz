<?php

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validateUser($email, $password)
    {
        $result = array();

        if (empty($email) || empty($password)) {
            $result['success'] = false;
            $result['error'] = 'Email/Password trống.';
            return $result;
        }

        $account = array('email' => $email, 'password' => $password);
        $sql = 'SELECT email, password, role, firstname, lastname
                FROM Users
                WHERE email = :email AND password = :password';

        $fetchedData = $this->_dbHandler->select($sql, $account,PDO::FETCH_ASSOC);

        if (count($fetchedData) == 1) {
            $result['success'] = true;
            $result['userData'] = $fetchedData;
        } else {
            $result['success'] = false;
            $result['error'] = 'Email/Password không chính xác.';
        }
        return $result;
    }
}
