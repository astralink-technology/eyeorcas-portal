define("devices/getDeviceListing", ['jquery', 'bootstrap', "devices/addDevice",
    "devices/editDevice", "devices/deleteDevice", 'core/confirmBox', 'core/ajaxLoader',
    'text!devices/templates/getDeviceListing.tmpl.ensg.htm'],
    function ($, bootstrap, addDevice, editDevice, deleteDevice, confirmBox, ajaxLoader, getDeviceListingTmpl) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    enterpriseId: '',
                    apiHost: '',
                    entityId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<ul class="list-inline js-mod-get-device-listing" id="device-listing-' + _settings.prefix + '" data-bind="source: devices" data-template="device-listing-entry"></ul>',
                        '<div id="add-device"></div>',
                        '<div id="edit-device"></div>',
                        '<div id="delete-device"></div>',
                        '<div id="loadDeviceModal"></div>',
                        '<div id="deviceDeleteModal"></div>'
                    ].join(''));

                $("head").append(getDeviceListingTmpl);
                methods._getDevices(settings.prefix);
             },
            _getDevices : function(prefix){
                var type2 = "S"
                var urlParms = "?OwnerId=" + _settings.entityId;
                urlParms += "&DeviceType2=" + type2;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/DeviceRelationshipResController/getEntityDeviceRelationshipDetails" + urlParms,
                    processData: true,
                    dataType: "json",
                    beforeSend: function(){
                        $("#device-listing-" + prefix).html("<img src='/img/ajax-loader.gif' /> </span><span>Fetching...</span>");
                    },
                    success: function (json) {
                        if (!json.error){
                            methods._displayDeviceList(json.data, prefix);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _displayDeviceList: function(data, prefix){
                var dataResult = data;
                var viewModel = kendo.observable({
                    devices: dataResult
                });
                $("#device-listing-" + prefix).html("");
                kendo.bind($('#device-listing-' + prefix), viewModel);
                //after binding, append the add device button
                var btnAddDevice =
                    [
                        '<li id="btn-add-device">',
                            '<div class="device add-device" data-toggle="modal" data-target="#addDeviceModal">',
                                '<div class="device-content">',
                                    '<i class="fa fa-plus"></i>',
                                '</div>',
                                '<label>Add Device</label>',
                            '</div>',
                        '</li>'
                    ].join('\n');
                $("#device-listing-" + prefix).append(btnAddDevice);
                methods._loadListingControls(prefix);
                $("#loadDeviceModal").ajaxLoader('finishLoading', 'LoadDevices');
            },
            _loadListingControls: function(prefix){
                        $('.device').each(function(){
                            var deviceId = $(this).data('deviceid');
                            if (deviceId){
                                $(this).click(function(e) {
                                    if (!$( e.target).hasClass('fa')) {
                                        window.location = '/devices/overview?id=' + deviceId;
                                    }
                                });
                            }
                });

                $("#btn-add-device").click(function(){
                    $("#add-device").addDevice({
                        prefix : "add-device",
                        entityId : _settings.entityId,
                        added : function(){
                            methods._reloadDeviceList(prefix);
                        }
                    });
                });
                $(".btn-edit-device").each(function(){
                    var deviceId = $(this).attr('data-deviceid');
                    var deviceRelationshipValueId = $(this).attr('data-devicerelationshipvalueid');
                    var deviceRelationshipId = $(this).attr('data-devicerelationshipid');
                    var deviceId = $(this).attr('data-deviceid');
                    var deviceCode = $(this).attr('data-devicecode');
                    var deviceName = $(this).attr('data-devicename');
                    var deviceType = $(this).attr('data-devicetype');
                    $(this).click(function(){
                        $("#edit-device").editDevice({
                            prefix : "edit-device",
                            deviceRelationshipValueId : deviceRelationshipValueId,
                            deviceRelationshipId : deviceRelationshipId,
                            deviceId : deviceId,
                            deviceCode : deviceCode,
                            deviceName : deviceName,
                            deviceType : deviceType,
                            enterpriseId: _settings.enterpriseId,
                            updated : function(){
                                methods._reloadDeviceList(prefix);
                            }
                        })
                    });
                });
                $(".btn-delete-device").each(function(){
                    var deviceId = $(this).attr('data-deviceid');
                    var deviceRelationshipId = $(this).attr('data-devicerelationshipid')
                    var deviceRelationshipValueId = $(this).attr('data-devicerelationshipvalueid')
                    var deviceName = $(this).attr('data-devicename');
                    $(this).click(function(){
                        $("#delete-device").confirmBox({
                            prefix : 'delete-device-' + deviceId,
                            confirmBoxTitle: 'Delete Device',
                            comfirmBoxText: 'Are you sure you want to delete ' + deviceName + '?',
                            confirmActionText : 'Delete',
                            notConfirmActionText : 'Cancel',
                            confirm: function(){
                                $("#edit-device").confirmBox('closeConfirmBox', 'delete-device-' + deviceId);
                                $("#deviceDeleteModal").ajaxLoader({
                                    prefix: 'DeleteDevice',
                                    title: "Delete Device",
                                    text: 'Deleting...'
                                });
                                $(this).deleteDevice({
                                    prefix : 'delete-device-' + deviceId,
                                    deviceRelationshipId : deviceRelationshipId,
                                    deviceRelationshipValueId : deviceRelationshipValueId,
                                    enterpriseId : _settings.enterpriseId,
                                    delete : function(){
                                        $("#deleteDeviceModal").ajaxLoader('finishLoading', 'DeleteDevice');
                                        methods._reloadDeviceList(prefix);
                                    }
                                });
                            }
                        })
                    });
                });
            },
            _reloadDeviceList : function(prefix){
                $('#device-listing-' + prefix).html("");
                //reload and get the devices
                methods._getDevices(prefix);
            }
    };
    $.fn.getDeviceListing = function (methodOrOptions) {
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
