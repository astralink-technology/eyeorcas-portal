require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core'
    }
});

require([
    'utils/validationUtils'
    , 'core/ajaxLoader'
],
function (
    validationUtils
    ) {

    function signUp(){
        var givenName = $("#tb-given-name").val();
        var familyName = $("#tb-first-name").val();
        var email = $("#tb-email").val();
        var checkEmailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        var valGivenName = validationUtils.validateRequired(givenName, "val-givenName", "Please enter your given name");
        var valFirstName = validationUtils.validateRequired(familyName, "val-firstName", "Please enter your first name");
        var valEmail = validationUtils.validateEmail(email, "val-email", "Please enter a valid email", null, true, "Please enter an email");

        if (!valGivenName || !valFirstName || !valEmail){
            return;
        }

        var parms = new Object();
        parms.GivenName = givenName;
        parms.FamilyName = familyName;
        parms.Email = email;

        var jsonstr = JSON.stringify(parms);

        $.ajax({
            type: "POST",
            url: "/account/signup",
            processData: true,
            data: {json: jsonstr},
            dataType: "json",
            beforeSend : function(){
                $("#modalAjaxLoader").ajaxLoader({
                    prefix: 'signUpLoader',
                    title: "Sign Up",
                    text: 'Sigining up...'
                });
            },
            success: function (json) {
                if (!json.error){
                    window.location = "/account/success";
                }else{
                    $("#signup-error").text(json.errorDesc);
                    $("#signup-error").show();
                    $("#modalAjaxLoader").ajaxLoader('finishLoading', 'signUpLoader');
                }
            },
            error: function (xhr) {
            }
        });
    }
    $(document).ready(function () {
        $("#tb-given-name").focus();

        //load the sign up controls
        $("#btn-signup").click(function(){
            signUp();
        });

        $(window).bind('keypress', function(e){
            if (e.keyCode == 13 ) {
                signUp();
            }
        });
    });
});
