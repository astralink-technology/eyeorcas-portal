define("devices/deleteConnectedPhoneToDevice", ['jquery', 'bootstrap'],
    function ($, bootstrap) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix: '',
                    phoneId : '',
                    enterpriseId: '',
                    apiHost: '',
                    delete : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                methods._deleteConnectedPhone(settings.phoneId);
            },
            _deleteConnectedPhone : function(phoneId){
                var parms = new Object();
                if (!phoneId){
                    return;
                }
                parms.PhoneId = phoneId;
                parms.EnterpriseId = _settings.enterpriseId;

                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/PhoneResController/removePhone",
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
    $.fn.deleteConnectedPhoneToDevice = function (methodOrOptions) {
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
