require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'core' : '/cp-front/js/custom/core',
        'utils': '/cp-front/js/utils'
    }
});

require([
    'utils/validationUtils'
    , 'core/ajaxLoader'
],
    function (
        validationUtils
        , ajaxLoader
        ) {

        function login(){
            var username = $("#tb-username").val();
            var password = $("#tb-password").val();

            var checkEmailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            var valUsername = validationUtils.validateEmail(username, "val-loginUsername", "Please enter a valid username", null, true, "Please enter a username");
            var valPassword = validationUtils.validateRequired(password, "val-loginPassword", "Please enter a password");
            if (!valUsername || !valPassword){
                return;
            }

            var parms = new Object();
            parms.Username = username;
            parms.Password = password;

            var parmsCheck = "?userlogin=" + username;

            var jsonstr = JSON.stringify(parms);

            //check for old password
            $.ajax({
                type: "GET",
                url: "/account/passwordOldCheck" + parmsCheck,
                beforeSend: function(){
                    $("#modalAjaxLoader").ajaxLoader({
                        prefix: 'logInLoading',
                        title: "Log In",
                        text: 'Sigining in...'
                    });
                },
                dataType: "json",
                success: function (json) {
                    if (!json.error){
                        if (json.data == false){
                            $.ajax({
                                type: "POST",
                                url: "/account/login",
                                processData: true,
                                data: {json:jsonstr},
                                dataType: "json",
                                success: function (json) {
                                    if (!json.error){
                                        window.location = "/devices";
                                    }else{
                                        $("#login-error").text(json.errorDesc);
                                        $("#login-error").show();
                                        $("#modalAjaxLoader").ajaxLoader('finishLoading', 'logInLoading');
                                    }
                                },
                                error: function (xhr) {
                                }
                            });
                        }else{
                            window.location = "/account/passwordOld?auth=" + json.data;
                        }
                    }else{
                        $("#login-error").text(json.errorDesc);
                        $("#login-error").show();
                        $("#modalAjaxLoader").ajaxLoader('finishLoading', 'logInLoading');
                    }
                },
                error: function (xhr) {
                }
            });
        }

        //On load events
        $(document).ready(function(){
            $("#tb-username").focus();

            $("#btn-login").click(function(){
                login();
            });
            $(window).bind('keypress', function(e){
                if (e.keyCode == 13 ) {
                    login();
                }
            });
        });
    });


