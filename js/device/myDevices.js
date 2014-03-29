require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core',
        'devices' : '/JSModules/device',
        'product' : '/JSModules/product',
        'messages' : '/JSModules/messages',
        'media' : '/JSModules/media',
        'text' : '/cp-front/js/textJs/text'
    }
});

require([
    'devices/addDevice'
    , 'devices/getDeviceListing'
    , 'product/registerProduct'
    , 'media/getStorageUsage'
    , 'messages/getSmsUsage'
    , 'messages/getPushUsage'
],
function (
        addDevice
        , getDeviceListing
        , registerProduct
        , getStorageUsage
        , getSmsUsage
        , getPushUsage
    ) {
    $(document).ready(function () {
        //register user with product popup
        $("#register-product").registerProduct({
            prefix : 'register-user',
            entityId : _currEntityId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });
        //load the devices
        $("#device-listing").getDeviceListing({
            prefix : 'my-devices',
            entityId : _currEntityId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });
        //getStorageUsage
        $("#storageUsage").getStorageUsage({
            prefix : 'storageUsage',
            entityId : _currEntityId,
            productId : _currProductId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });
        //getSmsUsage
        $("#smsUsage").getSmsUsage({
            prefix : 'smsUsage',
            entityId : _currEntityId,
            productId : _currProductId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });
        //getPushUsage
        $("#pushUsage").getPushUsage({
            prefix : 'pushUsage',
            entityId : _currEntityId,
            productId : _currProductId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });

        //overview controls
        $("#storageUsage").click(function(){
            window.location = "/media";
        });

        $("#pushUsage").click(function(){
            window.location = "/logs";
        });

        $("#smsUsage").click(function(){
            window.location = "/logs";
        });
    });
});
