var _filters = new Array();

require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core',
        'devices' : '/JSModules/device',
        'log' : '/JSModules/log',
        'text' : '/cp-front/js/textJs/text'
    }
});

require([
    'log/getActivityListings'
    , 'log/activityFilters'
],
function (
	getActivityListings
    , activityFilters
    ) {

    $(document).ready(function () {
        $("#activity-listings").getActivityListings({
                prefix : 'activityListing'
                , entityId: _currEntityId
                , deviceId: _currDeviceId
                , enterpriseId : _enterpriseId
                , apiHost : _apiHost
        });
        $("#activity-filters").activityFilters({
            prefix : 'activityFilters',
            filtersOnChange: function(filters){
                _filters = filters;
            },
            filtersOnLoad: function(filters){
                _filters = filters;
            }
        });
    });
});
