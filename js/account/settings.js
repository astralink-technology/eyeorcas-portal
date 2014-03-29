require.config({
    paths: {
        'bootstrap': ['/cp-front/js/bootstrap-3.0.2/js/bootstrap.min'],
        'core' : '/cp-front/js/custom/core',
        'utils': '/cp-front/js/utils'
    }
});

require([
    'utils/validationUtils'
    , 'core/ajaxLoader'
],
    function (
        validationUtils
        , ajaxLoader
        ) {

        //On load events
        $(document).ready(function(){
        });
    });


