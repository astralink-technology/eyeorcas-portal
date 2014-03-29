define("media/getStorageUsage", ['jquery'],
    function ($) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    entityId : '',
                    enterpriseId: '',
                    apiHost: '',
                    productId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="overview-entry">',
                                    '<div class="usage-data" id="storageUsage-' + settings.prefix + '"></div>',
                                    '<div class="denominator-data" id="denominator-' + settings.prefix + '"></div>',
                                    '<label>Storage</label>',
                         '</div>'
                    ].join(''));

                methods._getStorageUsage(settings.prefix);
	        methods._getDenominator(settings.prefix);
             },
            _getStorageUsage : function(prefix){
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
                                var mediaData = json.data;
                                var usedSize = 0;
                                for(var i = 0; i < json.totalRowsAvailable; i ++){
                                    if (mediaData[i].fileSize){
                                        usedSize = parseInt(usedSize) + parseInt(mediaData[i].fileSize);
                                    }else{
                                        usedSize = parseInt(usedSize) + 0;
                                    }
                                }
	   		        if (usedSize == 0) usedSize = '0';
	   		        else usedSize = (usedSize / Math.pow(1024, 3)).toFixed(3);
			        $("#storageUsage-" + prefix).html(usedSize + 'GB');
                            }else{
                                $("#storageUsage-" + prefix).html("0 GB");
                            }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
	    _getDenominator : function(prefix){
                var urlParms = "?ProductId=" + _settings.productId;
                urlParms += "&Type=" + "S";
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ProductValueResController/getProductValues" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
				            $("#denominator-" + prefix).html(json.data[0].value + json.data[0].valueUnit);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
            
    };
    $.fn.getStorageUsage = function (methodOrOptions) {
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
