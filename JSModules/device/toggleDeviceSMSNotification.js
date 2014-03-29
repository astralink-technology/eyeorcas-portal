define("devices/toggleDeviceSMSNotification", ['jquery', 'bootstrap', 'utils/dateTimeUtils', 'core/ajaxLoader', 'core/confirmBox'],
    function ($, bootstrap, dateTimeUtils, ajaxLoader, confirmBox){
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    deviceId : '',
                    deviceName : '',
                    apiHost: '',
                    enterpriseId: '',
                    updated : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<label class="enable-sms-notifications"><input type="checkbox" id="toggle-notification-' + settings.prefix + '"/> Enable SMS Notification</label>',
                        '<span id="modalAjaxLoader' + settings.prefix + '"></span>',
                        '<span id="confirmSMSNotification' + settings.prefix + '"></span>'
                ].join(''));
                //load the name of the device
                if (settings.deviceName){
                    $("#toggle-sms-device-name-" + settings.prefix).html('for <b>' + settings.deviceName + '</b>');
                }
                methods._getSMSStatusForDevice(settings.deviceId, settings.prefix);
            },
            _loadToggleControls: function(prefix, deviceId, deviceValueId){
                $("#toggle-notification-" + prefix).change(function(){
                    if ($(this).is(':checked')){
                        methods._confirmEnableSmsNotification(prefix, deviceId, deviceValueId);
                    }else{
                        methods._toggleSmsNotification(prefix, false, deviceId, deviceValueId);
                    }
                });
            },
            _getSMSStatusForDevice: function(deviceId, prefix){
                var urlParms = "?DeviceId=" + deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/DeviceValueResController/getDeviceValue" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            if (json.totalRowsAvailable > 0){
                                var deviceValueData = json.data[0];
                                if (deviceValueData.sms){
                                    $("#toggle-notification-" + prefix).prop('checked', true);
                                }else{
                                    $("#toggle-notification-" + prefix).prop('checked', false);
                                }
                                methods._loadToggleControls(prefix,deviceId, deviceValueData.deviceValueId);
                            }else{
                                methods._addSMSFeatureToDevice(prefix, deviceId);
                            }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _addSMSFeatureToDevice: function(prefix, deviceId){
                //add the device value if there are no device values for the HXS, this is a fix for the old HXS being added
                var parms = new Object();
                parms.DeviceId = deviceId;
                parms.EnterpriseId = _settings.enterpriseId;
                parms.Sms = true;
                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/DeviceValueResController/addDeviceValue",
                    processData: true,
                    data: {json:JSON.stringify(parms)},
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            //get the device value added and set the global device value Id
                            $("#toggle-notification-" + prefix).prop('checked', true);
                            methods._loadToggleControls(prefix, deviceId, json.data);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _confirmEnableSmsNotification: function(prefix, deviceId, deviceValueId){
                $("#confirmSMSNotification" + prefix).confirmBox({
                    prefix: 'confirmToggleSmsNotification',
                    confirmBoxTitle: 'SMS Notification',
                    comfirmBoxText: 'SMS Notifications will be chargeable',
                    confirmActionText : 'Confirm',
                    notConfirmActionText : 'Cancel',
                    confirm: function(){
                        $("#confirmSMSNotification" + prefix).confirmBox("closeConfirmBox", "confirmToggleSmsNotification");
                        methods._toggleSmsNotification(prefix, true, deviceId, deviceValueId);
                    },
                    cancel: function(){
                        $("#toggle-notification-" + prefix).prop("checked", false)
                    }
                });
            },
            _toggleSmsNotification: function(prefix, enable, deviceId, deviceValueId){
                        var title = "";
                        var content = "";
                        if (enable){
                            title = "Enable SMS Notifications";
                            content = "Enabling...";
                        }else{
                            title = "Disable SMS Notifications";
                            content = "Disabling...";
                        }

                        $("#modalAjaxLoader" + prefix).ajaxLoader({
                            prefix: 'toggleSmsNotifications',
                            title: title,
                            text: content
                        });
                        var parms = new Object();
                        if (!deviceValueId){
                            return; //device value id required
                        }
                        parms.DeviceId = deviceId;
                        parms.DeviceValueId = deviceValueId;
                        parms.Sms = enable;
                        parms.EnterpriseId = _settings.enterpriseId;

                        $.ajax({
                            type: "POST",
                            url: _settings.apiHost + "/DeviceValueResController/updateDeviceValue",
                            processData: true,
                            data: {json:JSON.stringify(parms)},
                            success: function (json) {
                                if (!json.error){
                                    //updated, does not send out notifications anymore
                                    $("#modalAjaxLoader" + prefix).ajaxLoader('finishLoading', 'toggleSmsNotifications')
                                }
                            },
                            error: function (xhr) {
                            }
                        });
            }
    };
    $.fn.toggleDeviceSMSNotification = function (methodOrOptions) {
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
