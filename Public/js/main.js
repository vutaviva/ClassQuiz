//Chu y ham main nay co the load bat dong bo,
// nghia la no khong chac se load truoc cac ham khac ma require trong trang
require.config({
    baseUrl: 'js/app',
    paths: {
        "jquery": '../libs/jquery'
    }
});

//common load for all web pages
require(['jquery'], function ($) {

});