define("devices/addDevice", ['jquery','bootstrap' , 'utils/validationUtils', 'core/ajaxLoader'],
    function ($, bootstrap, validationUtils, ajaxLoader) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix: '',
                    entityId : '',
                    enterpriseId: '',
                    apiHost: '',
                    modal: true,
                    added : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="modal fade js-mod-add-device" id="addDeviceModal' + _settings.prefix + '" tabindex="-1" role="dialog" aria-labelledby="addDeviceModal' + _settings.prefix + 'Label" aria-hidden="true">',
                            '<div class="modal-dialog">',
                                '<div class="modal-content">',
                                    '<div class="modal-header">',
                                        '<h4 class="modal-title" id="myModalLabel">Add Device</h4>',
                                    '</div>',
                                    '<div class="modal-body">',
                                        '<div class="full-block">',
                                            '<label>Name</label>',
                                            '<input type="text" id="tbDeviceName' + _settings.prefix + '" />',
                                            '<div class="alert alert-danger alert-sm" id="validate-device-name"></div>',
                                        '</div>',
                                        '<div class="full-block">',
                                            '<label>Device ID</label>',
                                            '<input type="text" id="tbDeviceCode' + _settings.prefix + '" />',
                                            '<div class="alert alert-danger alert-sm" id="validate-device-code"></div>',
                                        '</div>',
                                        '<div class="full-block">',
                                            '<label>Device Type</label>',
                                            '<ul class="list-inline">',
                                                '<li><label><input type="radio" name="devicetype" id="rdbDeviceType' + _settings.prefix + '" value="H" checked/> Home Station</label></li>',
                                                '<li><label><input type="radio" name="devicetype" id="rdbDeviceType' + _settings.prefix + '" value="M" /> Eye Micro</label></li>',
                                            '</ul>',
                                        '</div>',
                                    '</div>',
                                    '<div class="modal-footer">',
                                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-closeAddDevice' + _settings.prefix + '">Close</button>',
                                        '<button type="button" class="btn btn-primary" id="btn-addDevice' + _settings.prefix + '">Add Device</button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                        '<div id="deviceAddModal"></div>'
                    ].join(''));
                if (settings.modal){
                    $('#addDeviceModal' + _settings.prefix).modal();
                    $("#btn-addDevice" + settings.prefix).click(function(){
                        methods._addDevice();
                    })
                }
            },
            _addDevice : function(){
                var parms = new Object();
                var name = $("#tbDeviceName" + _settings.prefix).val();
                var code  = $("#tbDeviceCode" + _settings.prefix).val();

                parms.DeviceStatus = "V";
                parms.DeviceType = $("input:radio[name='devicetype']:checked").val();
                parms.DeviceType2 = "S";
                parms.EnterpriseId = _settings.enterpriseId;

                var valName = validationUtils.validateRequired(name, "validate-device-name", "Please enter a device name");
                var valCode = validationUtils.validateRequired(code, "validate-device-code", "Please enter device code");
                if (!valName || !valCode){
                    return;
                }

                if (!_settings.entityId){
                    //no entityId
                    return;
                }else{
                    parms.OwnerId = _settings.entityId;
                }

                parms.Name = $("#tbDeviceName" + _settings.prefix).val();
                parms.DeviceCode = $("#tbDeviceCode" + _settings.prefix).val();
                parms.Sms = true;

                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/DeviceRelationshipResController/addEntityDeviceRelationshipWithValues",
                    processData: true,
                    data: {json:JSON.stringify(parms)},
                    dataType: "json",
                    beforeSend: function(){
                        $('#addDeviceModal' + _settings.prefix).modal('hide');
                        $("#deviceAddModal").ajaxLoader({
                            prefix: 'AddDevice',
                            title: "Add Device",
                            text: 'Adding...'
                        });
                    },
                    success: function (json) {
                        $("#addDeviceModal").ajaxLoader('finishLoading', 'AddDevice');
                        if (!json.error){
                            //callback
                            _settings.added();
                        }else{
                            if (json.errorDesc == "Duplicate"){
                                alert("Device Exists");
                            }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.addDevice = function (methodOrOptions) {
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
