define("devices/deleteDevice", ['jquery', 'bootstrap', 'core/ajaxLoader'],
    function ($, bootstrap, ajaxLoader) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix: '',
                    deviceRelationshipId : '',
                    deviceRelationshipValueId : '',
                    enterpriseId: '',
                    apiHost: '',
                    delete : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                methods._deleteDevice(settings.deviceRelationshipId, settings.deviceRelationshipValueId);
            },
            _deleteDevice : function(deviceRelationshipId, deviceRelationshipValueId){
                var parms = new Object();

                if (!deviceRelationshipId || !deviceRelationshipValueId){
                    return;
                }
                parms.DeviceRelationshipValueId = deviceRelationshipValueId;
                parms.DeviceRelationshipId = deviceRelationshipId;
                parms.EnterpriseId = _settings.enterpriseId;

                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/DeviceRelationshipResController/removeEntityDeviceRelationshipWithValues",
                    processData: true,
                    data: {json:JSON.stringify(parms)},
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            //callback
                            _settings.delete();
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.deleteDevice = function (methodOrOptions) {
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
