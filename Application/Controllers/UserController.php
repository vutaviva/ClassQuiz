<?php

class UserController extends Controller
{
    private $_loginService;

    public function __construct()
    {
        parent::__construct();
        $this->_setModel('User');
        $this->_loginService = new LoginService($this->_model);
    }

    /**
     * Check whether user is logged in
     * If not, load form to login
     * otherwise, display homepage
     */
    function index()
    {
        $logged = $this->_loginService->checkLogin();
        if ($logged == false) {
            $this->loadLoginPage();
        } else {
            $this->loadDashboardPage();
        }
    }

    private function loadLoginPage()
    {
        $this->_setView(VIEW_PATH . 'User/Login.php');
        echo $this->_view->render();
    }

    private function loadDashboardPage()
    {
        $this->_setView(VIEW_PATH . 'User/Dashboard.php');
        echo $this->_view->render();
    }

    public function submitLogIn()
    {
        $result = $this->_loginService->runLogIn();
        if (isset($_POST['ajax'])) {
            $responseData = '';
            if ($result == true) {
                $responseData = '{"logIn":true}';
            } else {
                $responseData = json_encode($this->_model->getViewDataArray());
            }
            echo $responseData;
        } else {
            //javascript is disable
            if ($result == true) {
                //redirect to prevent user refresh page for sending $_POST again.
                header('Location: ' . BASE_URL);
            } else {
                $this->_setView(VIEW_PATH . 'User/Login.php');
                echo $this->_view->render();
            }
        }

//        $this->_setView(VIEW_PATH . 'User/Login.php');
//        $result = $this->_loginService->runLogIn();
//        if ($result == true) {
//            //redirect to prevent user refresh page for sending $_POST again.
//            header('Location: ' . BASE_URL);
//        } else {
//            echo $this->_view->output();
//        }
    }

    /**
     * Log out and delete session, cookie
     */
    public function logout()
    {
        $this->_loginService->runLogout();
        header('location: ' . BASE_URL);
    }

    /**
     * Checking log in
     * If user is logged in, display dashboard
     * otherwise, load sign up page.
     */
    public function signUp()
    {
        $logged = $this->_loginService->runLogIn();
        if ($logged == false) {
            $this->loadSignUpPage();
        } else {
            $this->loadDashboardPage();
        }
    }

    private function loadSignUpPage()
    {
        $this->_setView(VIEW_PATH . 'User/SignUp.php');
        echo $this->_view->render();
    }

    public function submitSignUp()
    {
        if ($this->_loginService->checkLogin() == true) {
            header('location: ' . BASE_URL);
            return;
        }
    }
}
