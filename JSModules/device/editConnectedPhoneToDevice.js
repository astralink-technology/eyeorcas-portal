define("devices/editConnectedPhoneToDevice", ['jquery', 'bootstrap' , 'utils/validationUtils', 'utils/dateTimeUtils', 'core/countryCodePhoneInput', 'core/ajaxLoader'],
    function ($, bootstrap, validationUtils, dateTimeUtils, countryCodePhoneInput, ajaxLoader){
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
                    phoneId : '',
                    deviceId : '',
                    enterpriseId: '',
                    apiHost: '',
                    modal: true,
                    updated : function(){}
                }, options);
                _settings = settings;
                var $element = $(element);
                $element.html(
                    [
                        '<div class="modal fade js-mod-add-connected-phone" id="editPhoneModal' + _settings.prefix + '" tabindex="-1" role="dialog" aria-labelledby="editPhoneModal' + _settings.prefix + 'Label" aria-hidden="true">',
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
                                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="btn-closeEditPhone' + _settings.prefix + '">Close</button>',
                                        '<button type="button" class="btn btn-primary" id="btn-editPhone' + _settings.prefix + '">Edit Phone</button>',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                        "<div id='connectedPhoneEditModal'></div>"
                ].join(''));
                //load the values
                methods._getPhoneInformation(settings.phoneId, settings.prefix);
                $("#editPhoneModal" + settings.prefix).modal();

                //load the edit phone controls
                $("#btn-editPhone" + settings.prefix).click(function(){
                    methods._editPhone(settings.prefix, settings.phoneId);
                });
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
            _getPhoneInformation: function(phoneId, prefix){
                var urlParms = "?PhoneId=" + phoneId;
                urlParms += "&EnterpriseId=" + _settings.enterpriseId;

                $.ajax({
                    type: "GET",
                    url: _settings.apiHost + "/PhoneResController/getPhones" + urlParms,
                    processData: true,
                    dataType: "json",
                    success: function (json) {
                        if (!json.error){
                            //set the controls
                            var phoneData = json.data[0];
                            if (phoneData){
                                _phoneDigits = phoneData.phoneDigits;
                                _phone = phoneData.digits;
                                _countryCode = phoneData.countryCode;
                                _code = phoneData.code;
                                _validPhoneNumber = true;
                                //instantiate the module and set the values
                                $("#tbPhoneInput" + prefix).countryCodePhoneInput({
                                    'prefix': "edit-connected-phone",
                                    'code' : _code,
                                    'countryCode' : _countryCode,
                                    'phone' : _phone,
                                    'phoneDigits' : _phoneDigits,
                                    onChange: methods._countryCodeChanged
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                    }
                });
            },
            _editPhone: function(prefix, phoneId){
                var parms = new Object();
                if (!phoneId){
                    //no deviceId
                    return;
                }

                parms.PhoneId= phoneId;
                parms.Code = _code;
                parms.PhoneDigits = _phoneDigits;
                parms.Digits = _phone;
                parms.CountryCode = _countryCode;
                parms.EnterpriseId = _settings.enterpriseId;

                $.ajax({
                    type: "POST",
                    url: _settings.apiHost + "/PhoneResController/updatePhone",
                    processData: true,
                    data: {json:JSON.stringify(parms)},
                    beforeSend: function(){
                        $('#editPhoneModal' + _settings.prefix).modal('hide');
                        $("#connectedPhoneEditModal").ajaxLoader({
                            prefix: 'EditConnectedPhone',
                            title: "Edit Phone",
                            text: 'Editing...'
                        });
                    },
                    success: function (json) {
                        $("#connectedPhoneEditModal").ajaxLoader('finishLoading', 'EditConnectedPhone');
                        if (!json.error){
                            //callback
                            _settings.updated();
                        }
                    },
                    error: function (xhr) {
                    }
                });
            }
    };
    $.fn.editConnectedPhoneToDevice = function (methodOrOptions) {
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
