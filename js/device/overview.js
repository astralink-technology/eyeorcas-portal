require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core',
        'devices' : '/JSModules/device',
        'media' : '/JSModules/media',
        'log' : '/JSModules/log'
    }
});

require([
    'devices/getDeviceConnectedCount'
    , 'media/getDeviceVideoCount'
    , 'log/getActivityLogCount'
],
function (
        getDeviceConnectedCount
        , getDeviceVideoCount
	    , getActivityLogCount
    ) {

    $(document).ready(function () {
 	$("#deviceConnectedCount").getDeviceConnectedCount({
            prefix : 'connectedDeviceCount',
            deviceId : _currDeviceId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
	});
 	$("#deviceVideoCount").getDeviceVideoCount({
            prefix : 'deviceVideoCount',
            deviceId : _currDeviceId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
	});
 	$("#deviceLogCount").getActivityLogCount({
            prefix : 'deviceLogCount',
            deviceId : _currDeviceId,
                entityId: _currEntityId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
	});
    });
});
