function loadSidebarControls(){
    $('#btn-sidebar-hide').click(function(){
        $(".side-scroll-bar h2").fadeOut('fast');
        $(".side-scroll-bar ul").fadeOut('fast', function(){
        $(".side-scroll-bar").animate({width:'toggle'});
        });
    });
    $('#btn-sidebar-show').click(function(){
        $(".side-scroll-bar").animate({width:'toggle'}, function(){
            $(".side-scroll-bar h2").fadeIn('fast');
            $(".side-scroll-bar ul").fadeIn('fast');

            $("html").click(function (e) {
                $("html").unbind("click");
                if (e.target.id == ".side-scroll-bar" || $(e.target).parents(".side-scroll-bar").size()) {
                    //inside click
                } else {
                    //outside click
                    $(".side-scroll-bar h2").fadeOut('fast');
                    $(".side-scroll-bar ul").fadeOut('fast', function(){
                    $(".side-scroll-bar").animate({width:'toggle'});
                    });
                }
            });
        });
    });
}

function loadHeaderControls(){
    $("#btn-settings").click(function(){
        $("#settings-dropdown").show('fast', function(){
            clickOutsideToClose("#settings-dropdown");
        });
    });

    //load logout controls
    $("#bt-logout").click(function(){
       window.location = "/account/logout";
    });
}

function loadFooterColor(){
    $("#footer").css("background-color",  "#000");
}

function clickOutsideToClose(container) {
    $("html").click(function (e) {
        if (e.target.id == container || $(e.target).parents(container).size()) {
            //inside click
        } else {
            //outside click
            $(container).hide('fast');
            $("html").unbind("click");
        }
    });
}
//On load events
$(document).ready(function(){
    loadSidebarControls();
    loadHeaderControls();
    loadFooterColor();
});
