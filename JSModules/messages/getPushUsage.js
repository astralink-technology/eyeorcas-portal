define("messages/getPushUsage", ['jquery'],
    function ($) {
        var _settings = null;

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    enterpriseId: '',
                    entityId : '',
                    apiHost: '',
		            productId : ''
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="overview-entry">',
                                    '<div class="usage-data" id="pushUsage-' + settings.prefix + '"></div>',
                                    '<div class="denominator-data" id="denominator-' + settings.prefix + '"></div>',
                                    '<label>Push Notifications</label>',
                         '</div>'
                    ].join(''));

                methods._getPushUsage(settings.prefix);
	        methods._getDenominator(settings.prefix);
             },
            _getPushUsage : function(prefix){
                var urlParms = "?OwnerId=" + _settings.entityId;
                urlParms += "&Type=" + "P";
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/MessageResController/getMessages" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
				$("#pushUsage-" + prefix).html(json.totalRowsAvailable);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
	    _getDenominator : function(prefix){
                var urlParms = "?ProductId=" + _settings.productId;
                urlParms += "&Type=" + "P";
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ProductValueResController/getProductValues" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
				$("#denominator-" + prefix).html(json.data[0].value);
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
            
    };
    $.fn.getPushUsage = function (methodOrOptions) {
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
