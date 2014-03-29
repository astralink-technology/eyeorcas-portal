define("log/activityFilters", ['jquery'],
    function ($) {
        var _settings = null;
        var _filters = new Array();

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    enterpriseId: '',
                    apiHost: '',
                    filtersOnChange: function(filters){ },
                    filtersOnLoad : function(filters){ }
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<h3>View</h3>',
                            '<ul class="list-unstyled">',
                            '<li><label class="inline"><input class="activity-filter-checkbox" id="cb-sms-' + settings.prefix + '" type="checkbox" value="sms" checked/> SMSes</label></li>',
                            '<li><label class="inline"><input class="activity-filter-checkbox" id="cb-push' + settings.prefix + '" type="checkbox" value="push" checked/> Push Notifications</label></li>',
                            '<li><label class="inline"><input class="activity-filter-checkbox" id="cb-log' + settings.prefix + '" type="checkbox" value="logs" checked/> Logs</label></li>',
                        '</ul>'
                    ].join(''));
                methods._loadActivityFilters();
             },
            _loadActivityFilters : function(){
                $('.activity-filter-checkbox').each(function(){
                    if ($(this).prop("checked")){
                        _filters.push($(this).val());
                    }
                    $(this).click(function(){
                       methods._activityFiltersOnChange();
                    });
                })
                _settings.filtersOnLoad(_filters);
            },
            _activityFiltersOnChange: function(){
                _filters = new Array();
                $('.activity-filter-checkbox').each(function(){
                    if ($(this).prop("checked")){
                        _filters.push($(this).val());
                    }
                });
               _settings.filtersOnChange(_filters);
            }
    };
    $.fn.activityFilters = function (methodOrOptions) {
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
