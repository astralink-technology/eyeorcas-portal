define("media/getMediaListingByEntity", ['jquery', 'core/videoPlayer', 'core/confirmBox'],
    function ($, videoPlayer, confirmBox) {
        var _settings = null;
        var _mediaEntryTemplateLoaded = false;
        var _mediaNullEntryTemplateLoaded = false;

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
                        '<ul class="list-inline js-mod-get-media-listing" id="media-listing-' + _settings.prefix + '" data-bind="source: media" data-template="media-listing-entry"></ul>',
                        '<div id="videoPlayer' + settings.prefix + '"></div>'
                    ].join(''));
                methods._getMedia(settings.prefix);
             },
            _getMedia : function(prefix){
                var urlParms = "?EntityId=" + _settings.entityId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/MediaResController/getMedia" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                                if (!json.error){
                                    if (json.totalRowsAvailable > 0){
                                        if (!_mediaEntryTemplateLoaded){
                                            $.get('/JSModules/media/templates/getMediaListing.tmpl.ensg.htm', function (templates) {
                                                $('head').append(templates);
                                                methods._displayMediaList(json.data, prefix);
                                                _mediaEntryTemplateLoaded = true;
                                            });
                                        }else{
                                            methods._displayMediaList(json.data, prefix);
                                        }
                                    }else{
                                        if (!_mediaNullEntryTemplateLoaded){
                                            $.get('/JSModules/media/templates/getMediaListing.null.tmpl.ensg.htm', function (templates) {
                                                $('head').append(templates);
                                                $('#media-listing-' + prefix).html($("#media-listing-null-entry").html());
                                                _mediaEntryTemplateLoaded = true;
                                            });
                                        }else{
                                            $('#media-listing-' + prefix).html($("#media-listing-null-entry").html());
                                        }
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
    $.fn.getMediaListingByEntity = function (methodOrOptions) {
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
