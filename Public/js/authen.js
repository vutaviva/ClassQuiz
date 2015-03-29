var xmlHttp;
createXMLHTTPRequest();

function createXMLHTTPRequest()
{
    try {
        if (window.XMLHttpRequest) {
            xmlHttp = new XMLHttpRequest();
        } else {
            xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
        }
        //return xmlhttp;
    } catch (err) {
        alert("loi tao AJAXX");
    }
}

function createErrorElement()
{
    try {
        if (document.getElementById("errorMessage") == null) {
            var errorElement = document.createElement("label");
            var brElement = document.createElement("br");
            errorElement.id = "errorMessage";
            var emailElement = document.getElementById("emailLabel");
            var parentElement = emailElement.parentNode;
            parentElement.insertBefore(errorElement,emailElement);
            parentElement.insertBefore(brElement,emailElement);
        }
    } catch (err) {
        alert("createErrorElement() has error: " + err);
    }
}

function checkEmptyField(emailValue, passValue)
{
    try {
        if (emailValue == "" || passValue == "") {
            createErrorElement();
            var errorElement = document.getElementById("errorMessage");
            errorElement.innerHTML = "Email/Password chưa nhập!";
            return false;
        } else {
            return true;
        }
    } catch (err) {
        alert(err);
        return false;
    }
}
function authenticate()
{
    try {
        var emailValue = document.getElementById("email").value;
        var passValue = document.getElementById("password").value;

        if (checkEmptyField(emailValue, passValue) == false) {
            return false;
        }

        var captcha = "";
        var captchaElement = document.getElementById('g-recaptcha');

        if (captchaElement != null && grecaptcha != null && grecaptcha.getResponse() != "") {
            captcha = '&g-recaptcha-response=' + grecaptcha.getResponse();
        }

        //send email, pass to server
        xmlHttp.open("POST", "user/submitLogin",true);
        xmlHttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
        xmlHttp.onreadystatechange = responseVerify;
        var formData = "email=" + emailValue + "&password=" + passValue + captcha;
        console.log(formData);
        xmlHttp.send(formData);
        return false;
    } catch (err) {
        alert("authenticate() is error: " + err);
        return false;
    }

}

function responseVerify()
{
    try {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            console.log(xmlHttp.responseText);
            var resultVerify = JSON.parse(xmlHttp.responseText);
            if (resultVerify.logIn == false) {
                createErrorElement();
                var errorElement = document.getElementById("errorMessage");
                errorElement.innerHTML  = resultVerify.logInMessage;
                if (resultVerify.captcha == true) {
                    if (document.getElementsByClassName("g-recaptcha").length == 0) {
                        var captchaElement = document.createElement("div");
                        captchaElement.setAttribute("class","g-recaptcha");
                        captchaElement.setAttribute("data-sitekey","6LdcZAMTAAAAANu7xyOgrjA6I3a9UAdMsK-hmRR2");

                        var breakElement = document.createElement("br");
                        var rememElement = document.getElementById("rememberMe");
                        var parentElement = rememElement.parentNode;
                        parentElement.insertBefore(captchaElement,rememElement);
                        parentElement.insertBefore(breakElement,rememElement);
                    } else {
                        grecaptcha.reset();
                    }

                    //<script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    var apigoogle = document.createElement("script");
                    apigoogle.setAttribute("src","https://www.google.com/recaptcha/api.js");
                    apigoogle.setAttribute("async","");
                    apigoogle.setAttribute("defer","");
                    apigoogle.setAttribute("id","captchagoogle");

                    var oldapi = document.getElementById("captchagoogle");
                    if ( oldapi != null) {
                        //document.body.replaceChild(apigoogle, oldapi);
                    } else {
                        document.body.appendChild(apigoogle);
                    }

                    //var rememberElement = document.getElementById("rememberMe");
                    //var widgetCaptcha = '<div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LdcZAMTAAAAANu7xyOgrjA6I3a9UAdMsK-hmRR2"></div> <br/>';
                    //rememberElement.insertAdjacentHTML("beforebegin",widgetCaptcha);
                    //var captchaElement = document.getElementById("g-recaptcha");
                    //captchaElement.style.display = "block";
                }
            } else {
                //location.reload(true);
            }
        }
    } catch (err) {
        alert("responseVerify() has error: " + err);
    }
}

