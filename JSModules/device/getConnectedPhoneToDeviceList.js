define("devices/getConnectedPhoneToDeviceList", ['jquery', 'bootstrap', 'devices/deleteConnectedPhoneToDevice', 'devices/editConnectedPhoneToDevice', 'core/confirmBox', 'core/ajaxLoader'],
    function ($, bootstrap, deleteConnectedPhoneToDevice, editConnectedPhoneToDevice,  confirmBox, ajaxLoader) {
        var _settings = null;
        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    deviceName: '',
                    deviceId : '',
                    enterpriseId: '',
                    apiHost: '',
                    entityId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<table class="table table-bordered" id="connected-phones-for-sms' + settings.prefix + '">',
                            '<thead>',
                                '<tr><td colspan="2">Phone numbers connected to <b>' + settings.deviceName + '</b></td></tr>',
                            '</thead>',
                            '<tbody></tbody>',
                        '</table>',
                        "<div id='deleteConnectedPhone'></div>",
                        "<div id='editConnectedPhone'></div>",
                        "<div id='loadConnectedPhoneModal'></div>",
                        "<div id='connectedPhoneDeleteModal'></div>"
                    ].join(''));
                methods._getPhones(settings.prefix);
            },
            _getPhones : function(prefix){
                var urlParms = "?DeviceId=" + _settings.deviceId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/PhoneResController/getPhones" + urlParms,
                    processData: true,
                    dataType: "json",
                    beforeSend: function(){
                        var tableLoadingContent = "<tr colspan='2'>" +
                                                        "<td><span><img src='/img/ajax-loader.gif' /> </span><span>Fetching...</span></td>" +
                                                    "</tr>";
                        $("#connected-phones-for-sms" + prefix + " tbody").html(tableLoadingContent);
                    },
                    success: function (json) {
                        var tableContent = "";
                        if (!json.error && json.totalRowsAvailable > 0 ){
                            var phoneData = json.data;
                            for(var i = 0; i < json.totalRowsAvailable; i ++){
                                tableContent +=
                                    "<tr>" +
                                        "<td><i class='fa fa-phone'></i> <span>" + phoneData[i].phoneDigits + "</span></td>" +
                                        "<td>" +
                                            "<a href='javascript:void(0)' data-phoneid='" + phoneData[i].phoneId + "' class='btn btn-link btn-xs btn-editConnectedPhone'><i class='fa fa-edit'></i></a>" +
                                            "<a href='javascript:void(0)' data-phoneid='" + phoneData[i].phoneId + "' data-phonedigits='" + phoneData[i].phoneDigits + "' class='btn btn-link btn-xs btn-deleteConnectedPhone'><i class='fa fa-trash-o'></i></a>" +
                                        "</td>" +
                                    "</tr>"
                            }
                        }else{
                            tableContent += "<tr>" +
                                                "<td colspan='2'>No phone number added for SMS Notification.</td>" +
                                            "</tr>"
                        }
                        $("#connected-phones-for-sms" + prefix + " tbody").html(tableContent);
                        $(".btn-editConnectedPhone").each(function (){
                            var phoneId = $(this).attr('data-phoneid');
                            $(this).click(function(){
                                $("#editConnectedPhone").editConnectedPhoneToDevice({
                                    prefix : 'editConnectedPhone',
                                    phoneId: phoneId,
                                    deviceId : _settings.deviceId,
                                    enterpriseId: _settings.enterpriseId,
                                    modal: true,
                                    updated : function(){
                                        methods.refreshConnectedPhoneGrid(prefix);
                                    }
                                })
                            })
                        });
                        $(".btn-deleteConnectedPhone").each(function (){
                            var phoneId = $(this).attr('data-phoneid');
                            var phoneDigits = $(this).attr('data-phonedigits');
                            $(this).click(function(){
                                $("#deleteConnectedPhone").confirmBox({
                                    prefix : 'delete-phone-' + phoneId,
                                    confirmBoxTitle: 'Delete Connected Phone',
                                    comfirmBoxText: 'Are you sure you want to delete ' + phoneDigits + '?',
                                    confirmActionText : 'Delete',
                                    notConfirmActionText : 'Cancel',
                                    confirm: function(){
                                        $("#connectedPhoneDeleteModal").ajaxLoader({
                                            prefix: 'DeleteConnectedPhone',
                                            title: "Delete Phone",
                                            text: 'Deleting...'
                                        });
                                        $("#deleteConnectedPhone").confirmBox('closeConfirmBox', 'delete-phone-' + phoneId);
                                        $(this).deleteConnectedPhoneToDevice({
                                            prefix: 'delete-phone-' + phoneId,
                                            phoneId : phoneId,
                                            enterpriseId : _settings.enterpriseId,
                                            delete : function(){
                                                methods.refreshConnectedPhoneGrid(prefix);
                                                $("#connectedPhoneDeleteModal").ajaxLoader('finishLoading', 'DeleteConnectedPhone');
                                            }
                                        });
                                    }
                                })
                            });
                        });
                    },
                    error: function (xhr) {
                    }
                });
            },
            refreshConnectedPhoneGrid : function(prefix){
                $("#connected-phones-for-sms" + prefix + " tbody").html("");
                methods._getPhones(prefix)
            }
    };
    $.fn.getConnectedPhoneToDeviceList = function (methodOrOptions) {
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
