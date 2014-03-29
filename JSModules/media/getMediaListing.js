define("media/getMediaListing", ['jquery', 'core/videoPlayer', 'core/confirmBox', 'text!media/templates/getMediaListing.tmpl.ensg.htm', 'text!media/templates/getMediaListing.null.tmpl.ensg.htm'],
    function ($, videoPlayer, confirmBox, getMediaListingTmpl, getMediaListingNullTmpl) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    deviceId : '',
                    enterpriseId: '',
                    apiHost: '',
                    entityId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<ul class="list-inline js-mod-get-media-listing" id="media-listing-' + _settings.prefix + '" data-bind="source: media" data-template="media-listing-entry"></ul>',
                        '<div id="videoPlayer' + settings.prefix + '"></div>'
                    ].join(''));
                $('head').append(getMediaListingNullTmpl);
                $('head').append(getMediaListingTmpl);
                methods._getMedia(settings.prefix, settings.deviceId, settings.entityId);
             },
            _getMedia : function(prefix, deviceId, entityId){
                var urlParms = "";

                if (!entityId){
                    return
                }else{
                    urlParms += "?OwnerId=" + entityId;
                }

                if (deviceId){
                    urlParms += "&DeviceId=" + deviceId;
                }
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/DeviceRelationshipResController/getDeviceRelationshipMedia" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            if (json.totalRowsAvailable > 0){
                                methods._displayMediaList(json.data, prefix);
                            }else{
                                $('#media-listing-' + prefix).html($("#media-listing-null-entry").html());
                            }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _displayMediaList: function(data, prefix){
                var dataResult = data;
                var viewModel = kendo.observable({
                    media: dataResult
                });
                kendo.bind($('#media-listing-' + prefix), viewModel);
                //bind the click for each media
                $(".video-poster").each(function(){
                    $(this).click(function(){
                        var url = $(this).data('url');
                        var id = $(this).data('id');
                        var title = $(this).data('title');
                        var description = $(this).data('description');
                        var poster = $(this).data('poster');
                        var type = $(this).data('type');

                        $("#videoPlayer" + prefix).videoPlayer({
                            prefix : 'videoPlayer',
                            videoId : id,
                            videoUrl : url,
                            videoTitle: title,
                            videoPoster: poster,
                            videoType: type,
                            playerWidth: '540',
                            modal: true
                        });
                    })
                })
            }
    };
    $.fn.getMediaListing = function (methodOrOptions) {
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
