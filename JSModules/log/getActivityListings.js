define("log/getActivityListings", ['jquery', "text!log/templates/getActivityListing.tmpl.ensg.htm",  "text!log/templates/getActivityListing.null.tmpl.ensg.htm"],
    function ($, getActivityListingTmpl, getActivityListingNullTmpl) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : ''
                    , deviceId : ''
                    , entityId : ''
                    , enterpriseId : ''
                    , apiHost: ''
                    , types: ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<ul class="list-unstyled js-mod-get-activity-listing" id="activity-listing-' + _settings.prefix + '" data-bind="source: activities" data-template="activity-listing-entry"></ul>'
                    ].join(''));

                $("head").append(getActivityListingTmpl);
                $("head").append(getActivityListingNullTmpl);
                methods._getActivitiesListings(settings.prefix, settings.entityId, settings.deviceId, settings.types);
             },
            _getActivitiesListings : function(prefix, entityId, deviceId, types){
                var urlParms = "";
                if (!entityId){
                    return;
                }else{
                    urlParms +="?OwnerId=" + entityId;
                }
                if (deviceId){
                    urlParms += "&DeviceId=" + deviceId;
                }
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ActivityResController/getActivities" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                                methods._displayActivitiesList(json.data, json.totalRowsAvailable, prefix);
                      }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _displayActivitiesList: function(data, totalRowsAvailable, prefix){
                if (totalRowsAvailable > 0){
                    var dataResult = data;
                    var viewModel = kendo.observable({
                        activities: dataResult
                    });
                    $("#activity-listing-" + prefix).html("");
                    kendo.bind($('#activity-listing-' + prefix), viewModel);
                }else{
                    $("#activity-listing-" + prefix).html($("#activity-listing-null-entry").html());
                }
            }
    };
    $.fn.getActivityListings = function (methodOrOptions) {
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
