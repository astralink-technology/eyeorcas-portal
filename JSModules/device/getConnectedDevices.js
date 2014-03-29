define("devices/getConnectedDevices", ['jquery', 'core/confirmBox', 'core/ajaxLoader'],
    function ($, confirmBox, ajaxLoader) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    deviceId : '',
                    apiHost: '',
                    enterpriseId: ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<h2>Connected Devices</h2>'
                    ].join(''));

                methods._getDevices(settings.prefix);
             },
            _getConnectedDevices : function(prefix){
                var urlParms = "?DeviceId=" + _settings.deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/DeviceSessionResController/getDeviceSession" + urlParms,
                    processData: true,
                    dataType: "json",
                    beforeSend: function(){
                        $("#device-connected-" + prefix).html("<img src='/img/ajax-loader.gif' /> </span><span>Fetching...</span>");
                    },
                    success: function (json) {
                        if (!json.error){

                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.getConnectedDevices = function (methodOrOptions) {
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
