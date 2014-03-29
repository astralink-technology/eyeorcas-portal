function setBackground(){
    var currentdate = new Date();
    var morning = new Date(currentdate.getFullYear(), (currentdate.getMonth() + 1), currentdate.getDate(), 7, 0, 0);
    var afternoon = new Date(currentdate.getFullYear(), (currentdate.getMonth() + 1), currentdate.getDate(), 13, 0, 0);
    var evening = new Date(currentdate.getFullYear(), (currentdate.getMonth() + 1), currentdate.getDate(), 18, 0, 0);
    var night = new Date(currentdate.getFullYear(), (currentdate.getMonth() + 1), currentdate.getDate(), 21, 0, 0);
        
    var currTime = new Date(currentdate.getFullYear(), (currentdate.getMonth() + 1), currentdate.getDate(), currentdate.getHours(), currentdate.getMinutes(), currentdate.getSeconds());
    
    if (currTime > morning && currTime < afternoon){
        //morning period
        $('.index .short-intro').css('color', '#ffffff');
        $('.index h1').css('color', '#000');
        $('.index h2').css('color', '#000');
        $('.controls .btn-link').css('color', '#ffffff');
        $('body').css('background-image', 'url(/P2P/img/sunrise.jpg)');
    }else if (currTime > afternoon && currTime < evening){
        //afternoon period
        $('.index .short-intro').css('color', '#000');
        $('.index h1').css('color', '#000');
        $('.index h2').css('color', '#000');
        $('.controls .btn-link').css('color', '#000');
        $('body').css('background-image', 'url(/P2P/img/noonclouds.jpg)');
    }else if (currTime > evening && currTime < night){
        //evening period
        $('.index .short-intro').css('color', '#ffffff');
        $('.index h1').css('color', '#000');
        $('.index h2').css('color', '#000');
        $('.controls .btn-link').css('color', '#000');
        $('body').css('background-image', 'url(/P2P/img/sunset.jpg)');
    }else{
        //night period
        $('.index .short-intro').css('color', '#ffffff');
        $('.index h1').css('color', '#ffffff');
        $('.index h2').css('color', '#ffffff');
        $('.full-block label').css('color', '#ffffff');
        $('.controls .btn-link').css('color', '#ffffff');
        $('body').css('background-image', 'url(/P2P/img/night.jpg)');
    }
}

function loadLogin(loadType){
    if (loadType == 'firstLoad'){
        $("#login-form").fadeIn(600);
    }else{
        $(".content").fadeOut(200, function(){
            setTimeout(function(){
                $("#login-form").fadeIn(500);
            }, 225)
        });
    }
}

function loadSignUp(){
    $(".content").fadeOut(200, function(){
        setTimeout(function(){
            $("#signup-form").fadeIn(500);
        }, 225)
    });
}

function loadForgetPassword(){
    $(".content").fadeOut(200, function(){
        setTimeout(function(){
            $("#forgetpassword-form").fadeIn(500);
        }, 225)
    });
}

function setPassword(){
    var newPassword = $("#tb-new-password").val();
    var confirmPassword = $("#tb-confirm-password").val();
    
    if (!_authId){
        //invitation expired
    }
    if (!newPassword){
        $("#val-newPassword").text("Please enter a password");
        $("#val-newPassword").show();
    }else{
        $("#val-newPassword").hide();
    }
    
    if (!confirmPassword){
        $("#val-confirmPassword").text("Please enter a confirmation password");
        $("#val-confirmPassword").show();
    }else{
        $("#val-confirmPassword").hide();
    }
    
    if (newPassword != confirmPassword){
        $("#setPassword-error").text("Password does not match")
        $("#setPassword-error").show();
    }else{
        $("#setPassword-error").hide();           
    }
        
    if (!confirmPassword || !newPassword || (newPassword != confirmPassword)){    
        return;
    }
    
    //ajax function here
    var parms = new Object();
    parms.AuthenticationID = _authId;
    parms.NewPassword = newPassword;
    var jsonstr = JSON.stringify(parms);  

    $.ajax({
        type: "POST",
        url: "/P2P/account/createPassword",
        processData: true,
        data: {json:jsonstr},
        dataType: "json",
        success: function (json) {
            if (json.error == false){
                registrationComplete();
                clearSetPasswordForm();
            }
        },
        error: function (xhr) {
        }
    });
}

function registrationComplete(){
    $(".content").fadeOut(200, function(){
        setTimeout(function(){
            $("#password-set-success").fadeIn(500);
        }, 225);
    });
    
    setTimeout(function(){
       window.location = "/P2P/"
    }, 300)
}

function signupSuccess(){
    $(".content").fadeOut(200, function(){
        setTimeout(function(){
            $("#signup-success").fadeIn(500);
        }, 255)
    });    
}

function forgetPasswordRequested(){
    $(".content").fadeOut(200, function(){
        setTimeout(function(){
            $("#password-requested-success").fadeIn(500);
        }, 255)
    });    
}

function clearSignupForm(){
    //clear all controls
    $("#GivenName").val("");
    $("#FamilyName").val("");
    $("#Email").val("");
    
    //hide all validation
    $("#val-familyName").fadeOut(200);
    $("#val-givenName").fadeOut(200);
    $("#val-email").fadeOut(200);
    $("#signup-error").fadeOut(200);
}

function clearLoginForm(){
    //clear all controls
    $("#tb-username").val("");
    $("#tb-password").val("");
    
    //hide all validation
    $("#val-loginUsername").fadeOut(200);
    $("#val-loginPassword").fadeOut(200);
}

function clearRequestPasswordForm(){
    //clear all controls
    $("#tb-forgotPasswordEmail").val("");
    
    //hide all validation
    $("#val-forgotPasswordEmail").fadeOut(200);    
}

function clearSetPasswordForm(){
    //clear all controls
    $("#tb-newPassword").val("");
    $("#tb-confirmPassword").val("");
    
    //hide all validation
    $("#val-newPassword").fadeOut(200);
    $("#val-confirmPassword").fadeOut(200);    
}

function login(){
    var username = $("#tb-username").val();
    var password = $("#tb-password").val();

    var checkEmailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!username || !checkEmailRegex.test(username)){
        $("#val-loginUsername").text("Please enter valid username"); //validation text
        $("#val-loginUsername").show(); //validation
    }else{
        $("#val-loginUsername").hide(); //validation
    }
    if (!password){
        $("#val-loginPassword").text("Please enter password"); //validation text
        $("#val-loginPassword").show(); //validation
    }else{
        $("#val-loginPassword").hide(); //validation
    }
    if (!username || !checkEmailRegex.test(username) || !password){
        return;
    }
        
    var parms = new Object();
    parms.Username = username;
    parms.Password = password;

    var jsonstr = JSON.stringify(parms);  

    $.ajax({
        type: "POST",
        url: "/P2P/account/login",
        processData: true,
        data: {json:jsonstr},
        dataType: "json",
        success: function (json) {
            if (!json.error){
                window.location = "/P2P/home/dashboard";
            }else{
                $("#login-error").text(json.errorDesc);
                $("#login-error").show();
            }
        },
        error: function (xhr) {
        }
    });
}

function requestPassword(){
    var email = $("#tb-username").val();
    var checkEmailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (!email || !checkEmailRegex.test(email)){
        $("#val-forgotPasswordEmail").text("Please enter a valid eamil"); //validation text
        $("#val-forgotPasswordEmail").show(); //validation
    }else{
        $("#val-forgotPasswordEmail").hide(); //validation
    }    
    
    if (!!email || !checkEmailRegex.test(email)){
        return;
    }
    
    clearRequestPasswordForm();
}

function signUp(){
	var givenName = $("#GivenName").val();
        var familyName = $("#FamilyName").val();
        var email = $("#Email").val();
        var checkEmailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!givenName){
            $("#val-givenName").text("Please enter Given Name"); //validation text
            $("#val-givenName").show(); //validation
        }else{
            $("#val-givenName").hide(); //validation
        }
        if (!familyName){
            $("#val-familyName").text("Please enter Family Name"); //validation text
            $("#val-familyName").show(); //validation
        }else{
            $("#val-familyName").hide(); //validation
        }
        if (!email || !checkEmailRegex.test(email)){
            $("#val-email").text("Please enter a valid Email"); //validation text
            $("#val-email").show(); //validation 
        }else{
            $("#val-email").hide(); //validation
        }
        
        if (!givenName || !familyName || !email || !checkEmailRegex.test(email)){
            return;
        }
        
        var parms = new Object();
        parms.GivenName = givenName;
        parms.FamilyName = familyName;
        parms.Email = email;

 	var jsonstr = JSON.stringify(parms);  

        $.ajax({
            type: "POST",
            url: "/P2P/account/signup",
	    processData: true,
            data: {json: jsonstr},
            dataType: "json",
            success: function (json) {
                if (!json.error){
		    signupSuccess();
                    clearSignupForm();
                }else{
                    $("#signup-error").text(json.errorDesc);
                    $("#signup-error").show();
                }
            },
            error: function (xhr) {
		alert("error");
            }
        });  
}

    function loadPublicControls(){
    //new to P2P control
    $(".bt-newToP2P").each(function(){
        $(this).click(function(){
            clearLoginForm();
            clearRequestPasswordForm();
            loadSignUp();
        });
    });
    //Have ann account control
    $(".bt-haveAnAccount").each(function(){
        $(this).click(function(){
            loadLogin('subsequentLoad');
            clearRequestPasswordForm();
            clearSignupForm();
        });        
    });
    //Forget Password control
    $("#bt-forgetPassword").click(function(){
        clearLoginForm();
        loadForgetPassword();
    });
    
    //Password request control
    $("#bt-retrieve-credentials").click(function(){
        requestPassword();
    });
    
    //Signup control
    $("#bt-signup").click(function(){
        signUp();
    })
    
    //Login control
    $("#bt-login").click(function(){
        login();
    })
    
    $('.bt-home').each(function(){
        //Navigate home control
        $(this).click(function(){
            loadLogin('subsequentLoad');
        })
    })
    
    $("#bt-setpassword").click(function(){
        setPassword();
    });
}


//On load events
$(document).ready(function(){
    setBackground(); 
    loadPublicControls();
    loadLogin("firstLoad");
});
