define("devices/editDevice", ['jquery', 'bootstrap' , 'utils/validationUtils', 'core/ajaxLoader'],
    function ($, bootstrap, validationUtils, ajaxLoader){
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix: '',
                    deviceRelationshipValueId : '',
                    deviceRelationshipId : '',
                    deviceId : '',
                    deviceCode : '',
                    deviceName : '',
                    deviceType : '',
                    enterpriseId: '',
                    apiHost: '',
                    updated : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="modal fade js-mod-add-device" id="editDeviceModal' + settings.prefix + '" tabindex="-1" role="dialog" aria-labelledby="editDeviceModal' + _settings.prefix + 'Label" aria-hidden="true">',
                            '<div class="modal-dialog">',
                                '<div class="modal-content">',
                                    '<div class="modal-header">',
                                        '<h4 class="modal-title" id="myModalLabel">Edit Device</h4>',
                                    '</div>',
                                    '<div class="modal-body">',
                                            '<div class="full-block">',
                                                '<label>Name</label>',
                                                '<input type="text" id="tbDeviceName' + settings.prefix + '" />',
                                            '</div>',
                                            '<div class="full-block">',
                                                '<label>Code</label>',
                                                '<input type="text" id="tbDeviceCode' + settings.prefix + '" />',
                                            '</div>',
                                            '<div class="full-block">',
                                                '<label>Device Type</label>',
                                                '<ul class="list-inline">',
                                                '<li><label><input type="radio" name="devicetype" id="tbDeviceCode' + _settings.prefix + '" value="H" checked/> Home Station</label></li>',
                                                '<li><label><input type="radio" name="devicetype" id="tbDeviceCode' + _settings.prefix + '" value="M" /> Eye Micro</label></li>',
                                                '</ul>',
                                            '</div>',
                                    '</div>',
                                    '<div class="modal-footer">',
                                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-closeEditDevice' + _settings.prefix + '">Close</button>',
                                        '<button type="button" class="btn btn-primary" id="btn-editDevice' + settings.prefix + '">Edit Device</button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                        '<div id="deviceEditModal"></div>'
                ].join(''));
                //load the values
                methods._getDeviceInformation(settings.deviceName, settings.deviceCode, settings.deviceType);
                $("#editDeviceModal" + settings.prefix).modal();

                //load the device settings
                $("#btn-editDevice" + settings.prefix).click(function(){
                    methods._editDevice(settings.prefix, settings.deviceId, settings.deviceRelationshipId, settings.deviceRelationshipValueId);
                });
             },
            _getDeviceInformation: function(deviceName, deviceCode, deviceType){
                //popuplate the edit form
                $("#tbDeviceName" + _settings.prefix).val(deviceName);
                $("#tbDeviceCode" + _settings.prefix).val(deviceCode);
                $('input[name="devicetype"][value="' + deviceType + '"]').prop('checked', true);
            },
            _editDevice: function(prefix, deviceId, deviceRelationshipId, deviceRelationshipValueId){
                var parms = new Object();
                var deviceName = $("#tbDeviceName" + _settings.prefix).val();
                var deviceCode = $("#tbDeviceCode" + _settings.prefix).val();
                var deviceType =  $("input:radio[name='devicetype']:checked").val();
                var valName = validationUtils.validateRequired(deviceName, "validate-device-name", "Please enter a device name");
                var valCode = validationUtils.validateRequired(deviceCode, "validate-device-code", "Please enter device code");

                if (!valName || !valCode){
                    return;
                }

                if (!deviceId || !deviceRelationshipId || !deviceRelationshipValueId){
                    //no deviceId
                    return;
                }

                parms.DeviceId = deviceId;
                parms.DeviceRelationshipId = deviceRelationshipId;
                parms.DeviceRelationshipValueId = deviceRelationshipValueId;
                parms.Name = deviceName;
                parms.DeviceCode = deviceCode;
                parms.DeviceType = deviceType;
                parms.EnterpriseId = _settings.enterpriseId;

                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/DeviceRelationshipResController/updateDeviceAndDeviceRelationshipWithValues",
                    processData: true,
                    data: {json:JSON.stringify(parms)},
                    beforeSend: function(){
                        $("#deviceEditModal").ajaxLoader({
                            prefix: 'EditDevice',
                            title: "Edit Device",
                            text: 'Editing...'
                        });
                        $('#editDeviceModal' + _settings.prefix).modal('hide');
                    },
                    success: function (json) {
                        $("#editDeviceModal").ajaxLoader('finishLoading', 'EditDevice');
                        if (!json.error){
                            //callback
                            _settings.updated();
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.editDevice = function (methodOrOptions) {
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
