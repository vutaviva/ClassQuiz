<?php include VIEW_PATH . 'Header.php' ?>

<h1>Đăng Nhập</h1>

<form id="loginForm" action= <?php echo (BASE_URL . 'user/submitLogin');?> method="post">
    <?php //for javascript is disabled
    if (isset(${LoginService::LOGIN_STATUS}) && ${LoginService::LOGIN_STATUS} == false) {
        echo '<noscript><label id="errorMessage">' . ${LoginService::LOGIN_MESSAGE} . '</label> <br/></noscript>';
    }
    ?>
    <label id="emailLabel">Email</label> <br />
    <input type="text" id ="email" name="email" /> <br />
    <label>Mật Khẩu</label> <br />
    <input type="password" id="password" name="password" /> <br />
    <input type="checkbox" id="rememberMe" name="rememberMe">
    <label>Ghi nhớ đăng nhập</label> <br/>
    <?php
        if (isset(${LoginService::LOGIN_CAPTCHA}) && ${LoginService::LOGIN_CAPTCHA} == true) {
            //for javascript is disabled
            require_once(ROOT_PATH . 'vendor/recaptchalib.php');
            echo recaptcha_get_html(CAPTCHA_PUBLIC_KEY);
            echo '<br/>';
        } else {
            echo('<div style="display:none" class="g-recaptcha" data-sitekey=' . CAPTCHA_PUBLIC_KEY . '></div> <br/>');
        }
    ?>
    <input type="submit" name="LoginSubmit" value="Đăng Nhập"/>
</form>

<a href=<?php echo (BASE_URL . 'User/signUp');?>>Đăng Kí</a> <br/>
<a href=<?php echo (BASE_URL . 'ForgetPassword');?>>Quên Mật Khẩu</a>

<?php include VIEW_PATH . 'Footer.php' ?>

<script>
    require(['app/loginPage']);
</script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
