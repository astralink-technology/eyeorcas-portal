require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'utils': '/cp-front/js/utils',
        'core' : '/cp-front/js/custom/core',
        'media' : '/JSModules/media',
        'text' : '/cp-front/js/textJs/text'
    }
});

require([
    'media/getMediaListing'
    , 'media/getMediaListingByEntity'
],
function (
    getMediaListing
    , getMediaListingByEntity
    ) {
    $(document).ready(function () {
        //load the media
        $("#video-gallery").getMediaListing({
            prefix : 'my-devices',
            deviceId : _currDeviceId,
            entityId : _currEntityId,
            apiHost : _apiHost,
            enterpriseId : _enterpriseId
        });
    });
});
