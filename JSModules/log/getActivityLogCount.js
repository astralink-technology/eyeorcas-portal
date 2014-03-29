define("log/getActivityLogCount", ['jquery'],
    function ($) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    entityId : '',
                    enterpriseId: '',
                    apiHost: '',
                    deviceId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                         '<div class="overview-entry" id="deviceLogCountOverview">',
                            '<div class="overview-data"  id="deviceLogCount-' + settings.prefix + '"></div>',
                            '<label>New Activities</label>',
                        '</div>'
                    ].join(''));

                methods._getActivitiesListingCount(settings.prefix, settings.entityId, settings.deviceId);
                $("#deviceLogCountOverview").click(function(){
                    window.location = "/logs?id=" + settings.deviceId;
                })
             },
            _getActivitiesListingCount : function(prefix, entityId, deviceId){
                var urlParms = "";
                if (!entityId){
                    return;
                }else{
                    urlParms +="?OwnerId=" + entityId;
                }
                if (deviceId){
                    urlParms += "&DeviceId=" + deviceId;
                }
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ActivityResController/getActivities" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            $("#deviceLogCount-" + prefix).html(json.totalRowsAvailable);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.getActivityLogCount = function (methodOrOptions) {
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
