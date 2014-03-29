define("media/getDeviceVideoCount", ['jquery'],
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
                        '<div class="overview-entry" id="deviceVideoCountOverview">',
                            '<div class="overview-data"  id="deviceVideoCount-' + settings.prefix + '"></div>',
                            '<label>New Video</label>',
                        '</div>'
                    ].join(''));

                methods._getDeviceVideoCount(settings.prefix);
                $("#deviceVideoCountOverview").click(function(){
                    window.location = "/media?id=" + settings.deviceId;
                })
             },
            _getDeviceVideoCount : function(prefix){
                var urlParms = "?OwnerId=" + _settings.deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/MediaResController/getMedia" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
				$("#deviceVideoCount-" + prefix).html(json.totalRowsAvailable);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
            
    };
    $.fn.getDeviceVideoCount = function (methodOrOptions) {
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
