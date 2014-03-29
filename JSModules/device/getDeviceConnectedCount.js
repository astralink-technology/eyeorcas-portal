define("devices/getDeviceConnectedCount", ['jquery'],
    function ($) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    enterpriseId: '',
                    apiHost: '',
                    deviceId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                         '<div class="overview-entry">',
                            '<div class="overview-data"  id="connectedDeviceCount-' + settings.prefix + '"></div>',
                            '<label>Device Connected</label>',
                        '</div>'

                    ].join(''));
                methods._getDeviceConnectedCount(settings.prefix);
             },
            _getDeviceConnectedCount : function(prefix){
                var urlParms = "?DeviceId=" + _settings.deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/DeviceSessionResController/getDeviceSession" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
			    $("#connectedDeviceCount-" + prefix).html(json.totalRowsAvailable);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
            
    };
    $.fn.getDeviceConnectedCount = function (methodOrOptions) {
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
