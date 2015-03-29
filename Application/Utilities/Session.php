<?php

//TODO: check browser is use cookie for all function of class

class Session
{

    public function __construct()
    {
        if (session_id() == '') {
            //set to persistent session, avoiding PHPSESSID expire when browser is closed.
            //Persistent session can be set in php.ini (session.cookie_lifetime) or
            // use ini_set function, session_set_cookie_params function
            //However, should make sure that session.gc_maxlifetime (time for collecting garbage of server)
            // must be set length than cookie expire time.
            ini_set('session.cookie_lifetime', LoginService::COOKIE_MAX_TIME);
            ini_set('session.gc_maxlifetime', LoginService::COOKIE_MAX_TIME);
            session_start();
        }
    }

    /**
     * registering session variable
     * @param $key
     * @param $value
     */
    public function set($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * registering session variable
     * @param $key
     * @param $value
     */
    public function remove($key)
    {
        if (!empty($key) && isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * read variable from session
     * @param $key
     * @return mixed value of variable in session or null
     */
    public function get($key)
    {
        if (!isset($_SESSION[$key])) {
            return null;
        } else {
            return $_SESSION[$key];
        }
    }

    /**
     * destroy session with clear data and expire cookie
     */
    public function destroy()
    {
        $_SESSION = array();

        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            setcookie(session_name(),'',time() - 2592000,'/');
        }
        session_destroy();
    }

    /**
     * save user's information for display other pages
     * @param $info
     * @throws Exception
     */
    public function setUserInfo($info)
    {
        if (empty($info)) {
            throw new Exception('Session can not set user info in setUserInfo because info is empty');
        }

        foreach ($info as $key => $value) {
            $_SESSION["$key"] = $value;
        }
    }
}
