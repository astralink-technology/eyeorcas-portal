define("product/registerProduct", ['jquery'],
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
                    modal : true
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="modal fade js-mod-register-product" id="productRegistrationModal' + _settings.prefix + '" tabindex="-1" role="dialog" aria-labelledby="productRegistrationModal' + _settings.prefix + 'Label" aria-hidden="true">',
                            '<div class="modal-dialog">',
                                '<div class="modal-content">',
                                    '<div class="modal-body">',
                                        '<h2>To get you started!</h2>',
                                        '<p>You get</p>',
                                        '<ul>',
                                            '<li>1000 Push Notifications</li>',
                                            '<li>500 SMS Notifications</li>',
                                            '<li>30 GB Storage</li>',
                                        '<ul>',
                                    '</div>',
                                    '<div class="modal-footer">',
                                        '<button type="button" class="btn btn-primary" data-dismiss="modal" id="btn-closeProductRegistrationModal' + _settings.prefix + '">Cool!</button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>'
                    ].join(''));

                methods._checkIfUserRegistered();
             },
            _checkIfUserRegistered: function (){
                var urlParms = "?OwnerId=" + _settings.entityId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ProductRegistrationResController/getProductRegistrations" + urlParms,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error && json.totalRowsAvailable < 1){
                            if (_settings.modal){
                                $('#productRegistrationModal' + _settings.prefix).modal();
                            }
                            //Hard code for now
                            methods._registerUserWithProduct('EYEORCAS-STARTER');
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _registerUserWithProduct : function(code){
                //get the starter product
                var urlParms = "?Code=" + code;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;
                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/ProductResController/getProducts" + urlParms,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            var productData = json.data[0];
                            //register the user with the product
                            var registrationParms = new Object();
                            registrationParms.EntityId = _settings.entityId;
                            registrationParms.ProductId = productData.productId;
                            registrationParms.Type = null;
                            registrationParms.Status = "V";
                            registrationParms.EnterpriseId = _settings.enterpriseId;
                            $.ajax({
                                type: "POST",
                                url: _settings.apiHost + "/ProductRegistrationResController/addProductRegistration",
                                processData: true,
                                data: {json:JSON.stringify(registrationParms)},
                                dataType: "json",
                                success: function (json) {
                                },
                                error: function (xhr) {
                                }
                            });
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.registerProduct = function (methodOrOptions) {
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
