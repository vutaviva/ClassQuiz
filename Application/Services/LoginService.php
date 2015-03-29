<?php

class LoginService
{
    const COOKIE_SITE_AUTH = 'siteAuth';
    const COOKIE_MAX_TIME = 2592000; // (3600 * 24 * 30) => 30 days

    const LOGIN_TRY_COUNT = 'logCount';
    const MAX_LOGIN_PERMIT = 3;

    const LOGIN_STATUS = 'logIn';
    const LOGIN_MESSAGE = 'logInMessage';
    const LOGIN_CAPTCHA = 'captcha';

    private $_session;
    private $_model;

    public function __construct($model)
    {
        $this->_session = new Session();
        $this->_model = $model;
    }

    /**
     * Check user is loged in using session
     * @return bool
     */
    public function checkLogin()
    {
        if (isset($_COOKIE[self::COOKIE_SITE_AUTH])) {
            $cookieStr = $_COOKIE[self::COOKIE_SITE_AUTH];
            if ($this->_session->get(self::COOKIE_SITE_AUTH) == $cookieStr) {
                session_regenerate_id(); //refresh session
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether Captcha is typed correctly.
     * @return bool
     */
    private function checkCaptcha()
    {
        try {
            $loginCount = $this->_session->get(self::LOGIN_TRY_COUNT);
            if ($loginCount < self::MAX_LOGIN_PERMIT || !isset($_POST['recaptcha_response_field'])) {
                return true;
            }

            if (!isset($_POST['ajax'])) {
                //for javascript is diabled
                require_once(ROOT_PATH . 'vendor/recaptchalib.php');
                $resp = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["recaptcha_challenge_field"],
                    $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    return false;
                } else {
                    return true;
                }
            } else {
                $response = file_get_contents(CAPTCHA_SERVER . "&response=" . $_POST['recaptcha_response_field']);
                $result = json_decode($response);

                if ($result->{'success'} == true) {
                    return true;
                } else {
                    # set the error code so that we can display it
                    //$error = error-codes;
                    return false;
                }
            }
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Check user whether has already logged in
     * if not, log in with email and password are posted or return false
     * @return bool  status of login (success or fail)
     */

    public function runLogIn()
    {
        if ($this->checkLogin() == true) {
            $this->_model->setViewData(self::LOGIN_STATUS, true);
            return true;
        }

        if (isset($_POST['email']) && isset($_POST['password']) &&
             !empty($_POST['email']) && !empty($_POST['password'])) {
            //check captcha
            if ($this->checkCaptcha() == false) {
                $this->_model->setViewData(self::LOGIN_STATUS, false);
                $this->_model->setViewData(self::LOGIN_MESSAGE, 'Captcha nhập không đúng');
                $this->_model->setViewData(self::LOGIN_CAPTCHA, true);
                return false;
            }

            //check email, password
            $result = $this->_model->validateUser($_POST['email'], $_POST['password']);
            if ($result['success'] == true) {
                $this->_session->setUserInfo($result['userData'][0]);
                $this->_session->remove(self::LOGIN_TRY_COUNT);

                $cookieStr = 'email=' . Security::hashing($_POST['email']);
                $this->_session->set(self::COOKIE_SITE_AUTH, $cookieStr);
                if (isset($_POST['rememberMe'])) {
                    setcookie(self::COOKIE_SITE_AUTH, $cookieStr, time() + self::COOKIE_MAX_TIME,'/');
                } else {
                    setcookie(self::COOKIE_SITE_AUTH, $cookieStr,0,'/'); //expire when close browser
                }

                $this->_model->setViewData(self::LOGIN_STATUS, true);
                return true;
            } else {
                $this->_model->setViewData(self::LOGIN_STATUS, false);
                $this->_model->setViewData(self::LOGIN_MESSAGE, $result['error']);
            }
        } else {
            $this->_model->setViewData(self::LOGIN_STATUS, false);
            $this->_model->setViewData(self::LOGIN_MESSAGE, 'User/Password chưa nhập!');
        }

        //times to try log in fail
        $loginCount = $this->_session->get(self::LOGIN_TRY_COUNT);
        if ($loginCount == false) {
            $loginCount = 1;
        } elseif ($loginCount < self::MAX_LOGIN_PERMIT) {
            $loginCount++;
        }
        $this->_session->set(self::LOGIN_TRY_COUNT, $loginCount);

        if ($loginCount == self::MAX_LOGIN_PERMIT)
        {
            $this->_model->setViewData(self::LOGIN_CAPTCHA, true);
        }

        return false;
    }

    /**
     * Log Out with delete session
     */
    public function runLogout()
    {
        if (isset($_COOKIE[self::COOKIE_SITE_AUTH])) {
            setcookie(self::COOKIE_SITE_AUTH, "", time() - self::COOKIE_MAX_TIME);
        }
        $this->_session->destroy();
    }
}