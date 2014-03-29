require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core',
        'devices' : '/JSModules/device',
        'moment' : '/cp-front/js/moment/moment.min',
        'kendo' : '/cp-front/js/kendo/js/kendo.web.min'
    }
});

require([
    'kendo',
    'devices/getConnectedPhoneToDeviceList',
    'devices/addConnectedPhoneToDevice',
    'devices/toggleDeviceSMSNotification'
],
function (
        kendo
        , getConnectedPhoneToDeviceList
        , addConnectedPhoneToDevice
        , toggleDeviceSMSNotification
    ) {
    function connectedPhoneAdded(){
        $("#connected-phone-listing").getConnectedPhoneToDeviceList("refreshConnectedPhoneGrid", "connectedPhone");
    }
    function smsNotificationUpdated(){

    }
    $(document).ready(function () {
        $("#connected-phone-listing").getConnectedPhoneToDeviceList({
            prefix : 'connectedPhone',
            entityId : _currEntityId,
            deviceId  : _currDeviceId,
            deviceName : _currDeviceName,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });

        $("#device-sms-notification-toggle").toggleDeviceSMSNotification({
            prefix : 'smsNotificationDeviceSettings',
            deviceId  : _currDeviceId,
            deviceName : _currDeviceName,
            updated : smsNotificationUpdated,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });

        $("#btn-addPhone").click(function(){
            $("#add-connected-phone").addConnectedPhoneToDevice({
                prefix : 'addConnectedPhone',
                entityId : _currEntityId,
                deviceId  : _currDeviceId,
                added: connectedPhoneAdded,
                apiHost : _apiHost,
                enterpriseId : _enterpriseId
            })
        })
    });
});
