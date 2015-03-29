define(["main", "jquery"], function(main, $) {
    //private data
    var email = "";
    var pass = "";
    var remember = "";
    var captchaResponse = "";
    var captchaOn = false;

    function getCaptcha()
    {
        try {
            var captchaElement = $(".g-recaptcha");
            var capt = "";
            if ((captchaElement.css('display') != 'none') && (typeof grecaptcha !== 'undefined')) {
                console.log(captchaElement.css('display'));
                captchaOn = true;
                capt = grecaptcha.getResponse();
            } else {
                captchaOn = false;
                capt = "";
            }

            return capt;

            //console.log(captcha);
        } catch (err) {
            console.log("getCaptcha() error: " + err.message);
        }
    }

    function getFormData()
    {
        try {
            email = $("#email")[0].value;
            pass = $("#password")[0].value;
            remember = $("#rememberMe").is(':checked');
            captchaResponse = getCaptcha();
            //console.log(email + ',' + pass + ',' + remember + ',' + captcha);
        } catch (err) {
            console.log("init() is problem:" + err.message);
        }
    }

    function enableCaptcha()
    {
        try {
            var recaptchaElement = $(".g-recaptcha");

            if (recaptchaElement.length > 0 && typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
                recaptchaElement.show();
            }
        } catch (err) {
            console.log("enableCaptcha is error because " + err.message);
        }
    }

    /**
     * Create label element to show error message to user.
     * @param message
     */
    function createMessageElement(message)
    {
        var errorElement = $("#errorMessage");
        if (errorElement.length == 0) {
            $("#emailLabel").before("<label id='errorMessage'>" + message + "</label> <br/>");
        } else {
            errorElement.text(message);
        }
    }

    /**
     * Send form data to server with ajax
     */
    function checkAccount() {
        try {
            var dataVerify = {
                email : email,
                password : pass,
                ajax: true      //use ajax to send
            };

            if (captchaOn == true) {
                dataVerify.recaptcha_response_field = captchaResponse;
            }

            if (remember == true) {
                //if checkbox is not check, it won't be sent to server
                dataVerify.rememberMe = true;
            }

            $.ajax({
                method: "POST",
                url: "user/submitLogin",
                data: dataVerify,
                success: responseCheck,
                error: function(xhr,status) {
                    console.log("Error post account to server: " + status);
                }
            });
        } catch (err) {
            console.log("checkEmptyFields is problem:" + err.message);
        }
    }

    /**
     * Ajax callback function after server response
     * @param data response from server
     */
    function responseCheck(data)
    {
        var resultVerify = JSON.parse(data);
        if (resultVerify.logIn == false) {
            var errElement = $("#errorMessage");
            if (errElement.length == 0) {
                $("#emailLabel").before("<label id='errorMessage'>" + resultVerify.logInMessage + "</label> <br/>");
            } else {
                errElement.text(resultVerify.logInMessage);
            }

            $("#password").val(''); //clear current password

            //Enable captcha because try log in more than limit number
            if (resultVerify.captcha == true) {
                enableCaptcha();
            }
        } else {
            location.reload();
        }
    }

    return {
        validateForm: function() {
            getFormData();
            if (email == "" || pass == "") {
                createMessageElement("Email/Password chưa nhập!");
                return false;
            }

            if (captchaOn == true && captchaResponse == "") {
                createMessageElement("Captcha chưa nhập đúng!");
                return false;
            }

            checkAccount();

            return false; //stop defauft post form
        }
    }
});