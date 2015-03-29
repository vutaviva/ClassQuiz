<html>
<head>
    <title>reCAPTCHA demo: Explicit render for multiple widgets</title>
</head>
<body>
<!-- The g-recaptcha-response string displays in an alert message upon submit. -->
<form action="user/test" method="POST">
    <div class="g-recaptcha" data-sitekey="6LdcZAMTAAAAANu7xyOgrjA6I3a9UAdMsK-hmRR2"></div> <br/>
    <input type="submit" value="mysubmit">
</form>
<br>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>