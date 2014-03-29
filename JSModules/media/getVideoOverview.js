define("media/getVideo", ['jquery'],
    function ($) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    deviceId : '',
                    enterpriseId: '',
                    apiHost: '',
                    modal : true
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<h2>Video</h2>'
                    ].join(''));
             },
            _getVideo : function(prefix){
                var urlParms = "?DeviceId=" + _settings.deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/MediaResController/getMedia" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                                if (!json.error){
                                    if (json.totalRowsAvailable > 0){

                                    }else{

                                    }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.getVideo = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist');
        }

        $(element).load(function () {
        });
    };
});
