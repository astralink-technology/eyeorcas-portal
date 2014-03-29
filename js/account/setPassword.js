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

    function setPassword(){
        var newPassword = $("#tb-new-password").val();
        var confirmPassword = $("#tb-confirm-password").val();

        if (!_authId){
            //invitation expired
        }

        //validation of password
        var validateNewPassword = validationUtils.validateRequired(newPassword, "val-newPassword", "Please enter a password.");
        var validateConfirmPassword = validationUtils.validateMatch(newPassword, confirmPassword, "val-confirmPassword", "Password does not match", false, true, "Please enter your password again.");

        if (!validateNewPassword || !validateConfirmPassword){
            return;
        }

        //ajax function here
        var parms = new Object();
        parms.AuthenticationID = _authId;
        parms.NewPassword = newPassword;
        var jsonstr = JSON.stringify(parms);

        $.ajax({
            type: "POST",
            url: "/account/createPassword",
            processData: true,
            data: {json:jsonstr},
            dataType: "json",
            beforeSend: function(){
                $("#modalAjaxLoader").ajaxLoader({
                    prefix: 'setPassword',
                    title: "Set Password",
                    text: 'Setting password...'
                });
            },
            success: function (json) {
                if (json.error == false){
                    window.location = "/"
                }else{
                $("#modalAjaxLoader").ajaxLoader('finishLoading', 'setPassword');
                }
            },
            error: function (xhr) {
            }
        });
    }
    $(document).ready(function () {
        $("#tb-new-password").focus();

        //load the sign up controls
        $("#btn-setpassword").click(function(){
            setPassword();
        });

        $(window).bind('keypress', function(e){
            if (e.keyCode == 13 ) {
                setPassword();
            }
        });
    });
});
