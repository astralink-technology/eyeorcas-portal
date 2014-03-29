var _smsMax = 450;
var _smsCurrentUsage = 125;
var _smsWarningFrom = 0;
var _smsWarningTo = 0;
var _smsBadWarningFrom = 0;
var _smsBadWarningTo = 0;
var _smsDangerFrom = 0;
var _smsDangerTo = 0;

var _pushMax = 400;
var _pushCurrentUsage = 200;
var _pushWarningFrom = 0;
var _pushWarningTo = 0;
var _pushBadWarningFrom = 0;
var _pushBadWarningTo = 0;
var _pushDangerFrom = 0;
var _pushDangerTo = 0;

var _storageMax = 40;
var _storageCurrentUsage = 37;
var _storageWarningFrom = 0;
var _storageWarningTo = 0;
var _storageBadWarningFrom = 0;
var _storageBadWarningTo = 0;
var _storageDangerFrom = 0;
var _storageDangerTo = 0;

function setParameters(){
    _smsWarningFrom = _smsMax * 0.7;
    _smsWarningTo = _smsMax * 0.8;
    _smsBadWarningFrom = _smsMax * 0.8;
    _smsBadWarningTo = _smsMax * 0.9;
    _smsDangerFrom = _smsMax * 0.9;
    _smsDangerTo = _smsMax;
    
    _storageWarningFrom = _storageMax * 0.7;
    _storageWarningTo = _storageMax * 0.8;
    _storageBadWarningFrom = _storageMax * 0.8;
    _storageBadWarningTo = _storageMax * 0.9;
    _storageDangerFrom = _storageMax * 0.9;
    _storageDangerTo = _storageMax;

    _pushWarningFrom = _pushMax * 0.7;
    _pushWarningTo = _pushMax * 0.8;
    _pushBadWarningFrom = _pushMax * 0.8;
    _pushBadWarningTo = _pushMax * 0.9;
    _pushDangerFrom = _pushMax * 0.9;
    _pushDangerTo = _pushMax;
}

function loadUsageGauges(){
    setParameters();
    $("#sms-gauge").kendoRadialGauge({
        pointer: {
            value: _smsCurrentUsage
        },
        scale: {
            minorUnit: 10,
            startAngle: -30,
            endAngle: 210,
            max: _smsMax,
            labels: {
                position: "inside"
            },
            ranges: [
                {
                    from: _smsWarningFrom,
                    to: _smsWarningTo,
                    color: "#ffc700"
                }, {
                    from: _smsBadWarningFrom,
                    to: _smsBadWarningTo,
                    color: "#ff7a00"
                }, {
                    from: _smsDangerFrom,
                    to: _smsDangerTo,
                    color: "#c20000"
                }
            ]
        }
    });
    $("#push-gauge").kendoRadialGauge({
        pointer: {
            value: _pushCurrentUsage
        },
        scale: {
            minorUnit: 5,
            startAngle: -30,
            endAngle: 210,
            max: _pushMax,
            labels: {
                position: "inside"
            },
            ranges: [
                {
                    from: _pushWarningFrom,
                    to: _pushWarningTo,
                    color: "#ffc700"
                }, {
                    from: _pushBadWarningFrom,
                    to: _pushBadWarningTo,
                    color: "#ff7a00"
                }, {
                    from: _pushDangerFrom,
                    to: _pushDangerTo,
                    color: "#c20000"
                }
            ]
        }
    });
    $("#storage-gauge").kendoRadialGauge({
        pointer: {
            value: _storageCurrentUsage
        },
        scale: {
            minorUnit: 5,
            startAngle: -30,
            endAngle: 210,
            max: _storageMax,
            labels: {
                position: "inside"
            },
            ranges: [
                {
                    from: _storageWarningFrom,
                    to: _storageWarningTo,
                    color: "#ffc700"
                }, {
                    from: _storageBadWarningFrom,
                    to: _storageBadWarningTo,
                    color: "#ff7a00"
                }, {
                    from: _storageDangerFrom,
                    to: _storageDangerTo,
                    color: "#c20000"
                }
            ]
        }
    });
}
//On load events
$(document).ready(function(){
    loadUsageGauges();
});
