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
    function updatePassword(){
        var oldPassword = $("#tb-old-password").val();
        var newPassword = $("#tb-new-password").val();
        var confirmPassword = $("#tb-confirm-password").val();

        if (!_currAuthId){
            //invitation expired
        }

        //validation of password
        var validateOldPassword = validationUtils.validateRequired(oldPassword, "val-oldPassword", "Please enter current password.");
        var validateNewPassword = validationUtils.validateRequired(newPassword, "val-newPassword", "Please enter a password.");
        var validateConfirmPassword = validationUtils.validateMatch(newPassword, confirmPassword, "val-confirmPassword", "Password does not match", false, true, "Please enter your password again.");

        if (!validateNewPassword || !validateConfirmPassword || !validateOldPassword){
            return;
        }

        //ajax function here
        var parms = new Object();
        parms.AuthenticationID = _currAuthId;
        parms.OldPassword = oldPassword;
        parms.NewPassword = newPassword;

        var jsonstr = JSON.stringify(parms);
        $.ajax({
            type: "POST",
            url: "/account/changePassword",
            processData: true,
            data: {json:jsonstr},
            dataType: "json",
            beforeSend: function(){
                $("#modalAjaxLoader").ajaxLoader({
                    prefix: 'setPassword',
                    title: "Update Password",
                    text: 'Updating...'
                });
            },
            success: function (json) {
                if (json.error == false){
                     window.location = "/profile";
                }else{
                    $("#oldpassword-error").show();
                    $("#oldpassword-error").html(json.errorDesc);
                    $("#modalAjaxLoader").ajaxLoader('finishLoading', 'setPassword');
                }
            },
            error: function (xhr) {
            }
        });
    }
    $(document).ready(function () {
        $("#tb-old-password").focus();
        //load the sign up controls
        $("#btn-update-password").click(function(){
            updatePassword();
        });

        $(window).bind('keypress', function(e){
            if (e.keyCode == 13 ) {
                updatePassword();
            }
        });
    });
});
