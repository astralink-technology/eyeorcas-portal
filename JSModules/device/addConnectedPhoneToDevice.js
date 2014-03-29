define("devices/addConnectedPhoneToDevice", ['jquery', 'bootstrap', 'core/countryCodePhoneInput', 'core/ajaxLoader'],
    function ($, bootstrap, countryCodePhoneInput, ajaxLoader) {
        var _settings = null;
        var _validPhoneNumber = false;
        var _code = "";
        var _countryCode = "";
        var _phone = "";
        var _phoneDigits = "";

        var methods = {
            init: function (options) {
                var element = this;
                var settings = $.extend({
                    prefix : '',
                    entityId : '',
                    deviceId : '',
                    enterpriseId: '',
                    apiHost: '',
                    modal: true,
                    added: function(){ }
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="modal fade js-mod-add-connected-phone" id="addPhoneModal' + _settings.prefix + '" tabindex="-1" role="dialog" aria-labelledby="addPhoneModal' + _settings.prefix + 'Label" aria-hidden="true">',
                            '<div class="modal-dialog">',
                                '<div class="modal-content">',
                                    '<div class="modal-header">',
                                        '<h4 class="modal-title" id="myModalLabel">Add Phone Number</h4>',
                                    '</div>',
                                    '<div class="modal-body">',
                                        '<div class="full-block">',
                                            '<label>Phone Number</label>',
                                            '<div id="tbPhoneInput' + _settings.prefix + '"></div>',
                                        '</div>',
                                    '</div>',
                                    '<div class="modal-footer">',
                                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-closeAddPhone' + _settings.prefix + '">Close</button>',
                                        '<button type="button" class="btn btn-primary" id="btn-addPhone' + _settings.prefix + '">Add Phone</button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                        "<div id='connectedPhoneAddModal'></div>"
                    ].join(''));
                if (settings.modal){
                    $('#addPhoneModal' + _settings.prefix).modal();
                    $("#btn-addPhone" + settings.prefix).click(function(){
                        methods._addPhone();
                    })
                }

                //load country code dropdown
                $("#tbPhoneInput" + settings.prefix).countryCodePhoneInput({
                    prefix: 'addConnectedDeviceCC',
                    onChange: methods._countryCodeChanged,
                    onLoad: methods._countryCodeLoaded
                })
            },
            _countryCodeLoaded: function(phoneWithCode){
                _code = phoneWithCode.code; //65
                _countryCode = phoneWithCode.countryCode; //sg
                _phone = phoneWithCode.phone; //pure digits
                _phoneDigits = phoneWithCode.phoneDigits; //concatenated number
                if (_phone){
                    _validPhoneNumber = true;
                }else{
                    _validPhoneNumber = false;
                }
            },
            _countryCodeChanged : function(phoneWithCode){
                _code = phoneWithCode.code; //65
                _countryCode = phoneWithCode.countryCode; //sg
                _phone = phoneWithCode.phone; //pure digits
                _phoneDigits = phoneWithCode.phoneDigits; //concatenated number
                if (_phone){
                    _validPhoneNumber = true;
                }else{
                    _validPhoneNumber = false;
                }
            },
            _addPhone : function(){
                if (_validPhoneNumber){
                    var parms = new Object();
                    parms.Code = _code;
                    parms.PhoneDigits = _phoneDigits;
                    parms.Digits = _phone;
                    parms.CountryCode = _countryCode;
                    parms.DeviceId = _settings.deviceId;
                    parms.EnterpriseId = _settings.enterpriseId;

                    $.ajax({
                        type: "POST",
                        url: _settings.apiHost + "/PhoneResController/addPhone",
                        processData: true,
                        data: {json:JSON.stringify(parms)},
                        dataType: "json",
                        beforeSend: function(){
                            $("#connectedPhoneAddModal").ajaxLoader({
                                prefix: 'AddConnectedPhone',
                                title: "Add Phone",
                                text: 'Adding...'
                            });
                            $('#addPhoneModal' + _settings.prefix).modal('hide');
                        },
                        success: function (json) {
                            $("#connectedPhoneAddModal").ajaxLoader('finishLoading', 'AddConnectedPhone');
                            if (!json.error){
                                //callback
                                _settings.added();
                            }
                        },
                        error: function (xhr) {
                        }
                    });
                }
            }
    };
    $.fn.addConnectedPhoneToDevice = function (methodOrOptions) {
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
