require(['main', 'jquery', 'loginValidation'], function(main, $, validation) {
    //register events
    //$('loginForm').submit(validation.checkEmptyFields);
    //alert(validation.checkEmptyFields);
    //alert($('loginForm').id);
    $(document).ready(function() {
        $('#loginForm').on('submit', validation.validateForm);
    });
});