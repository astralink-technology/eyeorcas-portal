<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceValueDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_DeviceValueResController
{
    public function getDeviceValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceValueId = null;
        $push = null;
        $sms = null;
        $token  = null;
        $type  = null;
        $resolution  = null;
        $quality  = null;
        $deviceId  = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        $locationName= null;
        $latitude = null;
        $longitude = null;
        $firmwareVersion = null;
        $appVersion = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceValueId'])){ $deviceValueId = $_GET['DeviceValueId']; };
        if (isset($_GET['Push'])){ $push = $_GET['Push']; };
        if (isset($_GET['Sms'])){ $sms = $_GET['Sms']; };
        if (isset($_GET['Token'])){ $token = $_GET['Token']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['Resolution'])){ $resolution = $_GET['Resolution']; };
        if (isset($_GET['Quality'])){ $quality = $_GET['Quality']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };
        if (isset($_GET['LocationName'])){ $locationName = $_GET['LocationName']; };
        if (isset($_GET['Latitude'])){ $latitude = $_GET['Latitude']; };
        if (isset($_GET['Longitude'])){ $longitude = $_GET['Longitude']; };
        if (isset($_GET['AppVersion'])){ $appVersion = $_GET['AppVersion']; };
        if (isset($_GET['FirmwareVersion'])){ $firmwareVersion = $_GET['FirmwareVersion']; };

        //get the json formatted data
        $deviceValueDb = new cp_create_device_value_dao();
        $deviceValueRes = $deviceValueDb->getDeviceValue(
            $deviceValueId
            , $push
            , $sms
            , $token
            , $type
            , $resolution
            , $quality
            , $deviceId
            , $pageSize
            , $skipSize
            , $enterpriseId
            , $locationName
            , $latitude
            , $longitude
            , $appVersion
            , $firmwareVersion
        );

        if ($databaseHelper->hasDataNoError($deviceValueRes)){
            $dataResponse->dataResponse($deviceValueRes['Data'], $deviceValueRes['ErrorCode'], $deviceValueRes['ErrorMessage'], $deviceValueRes['Error'], $deviceValueRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $deviceValueRes['ErrorCode'], $deviceValueRes['ErrorMessage'], $deviceValueRes['Error']);
        }
        return;
    }

    public function addDeviceValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newDeviceValue = json_decode($jsonPost, true);

            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $salt = null;
            $deviceId = null;
            $description = null;
            $enterpriseId = null;
            $locationName = null;
            $latitude = null;
            $longitude = null;
            $appVersion = null;
            $firmwareVersion = null;

            if (isset($newDeviceValue['EnterpriseId'])){ $enterpriseId = $newDeviceValue['EnterpriseId']; };
            if (isset($newDeviceValue['Push'])){ $push = $newDeviceValue['Push']; };
            if (isset($newDeviceValue['Sms'])){ $sms = $newDeviceValue['Sms']; };
            if (isset($newDeviceValue['Token'])){ $token = $newDeviceValue['Token']; };
            if (isset($newDeviceValue['Type'])){ $type = $newDeviceValue['Type']; };
            if (isset($newDeviceValue['Resolution'])){ $resolution = $newDeviceValue['Resolution']; };
            if (isset($newDeviceValue['Quality'])){ $quality = $newDeviceValue['Quality']; };
            if (isset($newDeviceValue['Hash'])){ $hash = $newDeviceValue['Hash']; };
            if (isset($newDeviceValue['Salt'])){ $salt = $newDeviceValue['Salt']; };
            if (isset($newDeviceValue['DeviceId'])){ $deviceId = $newDeviceValue['DeviceId']; };
            if (isset($newDeviceValue['Description'])){ $description = $newDeviceValue['Description']; };
            if (isset($newDeviceValue['LocationName'])){ $locationName = $newDeviceValue['LocationName']; };
            if (isset($newDeviceValue['Latitude'])){ $latitude = $newDeviceValue['Latitude']; };
            if (isset($newDeviceValue['Longitude'])){ $longitude = $newDeviceValue['Longitude']; };
            if (isset($newDeviceValue['AppVersion'])){ $appVersion = $newDeviceValue['AppVersion']; };
            if (isset($newDeviceValue['FirmwareVersion'])){ $firmwareVersion = $newDeviceValue['FirmwareVersion']; };

            //get the json formatted data
            $deviceValueDb = new cp_create_device_value_dao();
            $addDeviceValueRes = $deviceValueDb->createDeviceValue(
                $push
                , $sms
                , $token
                , $type
                , $resolution
                , $quality
                , $hash
                , $salt
                , $deviceId
                , $description
                , $enterpriseId
                , $locationName
                , $latitude
                , $longitude
                , $appVersion
                , $firmwareVersion
            );

            if ($databaseHelper->hasDataNoError($addDeviceValueRes)){
                $dataResponse->dataResponse($addDeviceValueRes['Id'], $addDeviceValueRes['ErrorCode'], $addDeviceValueRes['ErrorMessage'], $addDeviceValueRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addDeviceValueRes['ErrorCode'], $addDeviceValueRes['ErrorMessage'], $addDeviceValueRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateDeviceValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceValue = json_decode($jsonPost, true);

            $deviceValueId = null;
            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $salt = null;
            $lastUpdate = null;
            $deviceId = null;
	        $description = null;
	        $enterpriseId = null;
	        $locationName = null;
	        $latitude = null;
	        $longitude = null;
	        $appVersion = null;
	        $firmwareVersion = null;

            if (isset($updateDeviceValue['EnterpriseId'])){ $enterpriseId = $updateDeviceValue['EnterpriseId']; };
            if (isset($updateDeviceValue['DeviceValueId'])){ $deviceValueId = $updateDeviceValue['DeviceValueId']; };
            if (isset($updateDeviceValue['Push'])){ $push = $updateDeviceValue['Push']; };
            if (isset($updateDeviceValue['Sms'])){ $sms = $updateDeviceValue['Sms']; };
            if (isset($updateDeviceValue['Token'])){ $token = $updateDeviceValue['Token']; };
            if (isset($updateDeviceValue['Type'])){ $type = $updateDeviceValue['Type']; };
            if (isset($updateDeviceValue['Resolution'])){ $resolution = $updateDeviceValue['Resolution']; };
            if (isset($updateDeviceValue['Quality'])){ $quality = $updateDeviceValue['Quality']; };
            if (isset($updateDeviceValue['Hash'])){ $hash = $updateDeviceValue['Hash']; };
            if (isset($updateDeviceValue['Salt'])){ $salt = $updateDeviceValue['Salt']; };
            if (isset($updateDeviceValue['LastUpdate'])){ $lastUpdate = $updateDeviceValue['LastUpdate']; };
            if (isset($updateDeviceValue['DeviceId'])){ $deviceId = $updateDeviceValue['DeviceId']; };
            if (isset($updateDeviceValue['Description'])){ $description = $updateDeviceValue['Description']; };
            if (isset($updateDeviceValue['LocationName'])){ $locationName = $updateDeviceValue['LocationName']; };
            if (isset($updateDeviceValue['Latitude'])){ $latitude = $updateDeviceValue['Latitude']; };
            if (isset($updateDeviceValue['Longitude'])){ $longitude = $updateDeviceValue['Longitude']; };
            if (isset($updateDeviceValue['AppVersion'])){ $appVersion = $updateDeviceValue['AppVersion']; };
            if (isset($updateDeviceValue['FirmwareVersion'])){ $firmwareVersion = $updateDeviceValue['FirmwareVersion']; };

            //device Id and entity Id is required for editing the device
            if ($deviceValueId != null){
                //get the json formatted data
                $deviceValueDb = new cp_create_device_value_dao();
                $updateDeviceValueRes = $deviceValueDb->updateDeviceValue(
                    $deviceValueId
                    , $push
                    , $sms
                    , $token
                    , $type
                    , $resolution
                    , $quality
                    , $hash
                    , $salt
                    , $lastUpdate
                    , $deviceId
		            , $description
		            , $enterpriseId
		            , $locationName
		            , $latitude
		            , $longitude
		            , $appVersion
		            , $firmwareVersion
                );

                if ($databaseHelper->hasDataNoError($updateDeviceValueRes)){
                    $dataResponse->dataResponse($updateDeviceValueRes['Id'], $updateDeviceValueRes['ErrorCode'], $updateDeviceValueRes['ErrorMessage'], $updateDeviceValueRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateDeviceValueRes['ErrorCode'], $updateDeviceValueRes['ErrorMessage'], $updateDeviceValueRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, 'Device Value ID is required', true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeDeviceValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteDeviceValue = json_decode($jsonPost, true);

            $deviceId = null;
            $enterpriseId = null;
            $deviceValueId = null;

            if (isset($deleteDeviceValue['EnterpriseId'])){ $enterpriseId = $deleteDeviceValue['EnterpriseId']; };
            if (isset($deleteDeviceValue['DeviceId'])){ $deviceId = $deleteDeviceValue['DeviceId']; };
            if (isset($deleteDeviceValue['DeviceValueId'])){ $deviceValueId = $deleteDeviceValue['DeviceValueId']; };

            //device Id is required to delete the device
            if ($deviceValueId != null){
                //get the json formatted data
                $deviceValueDb = new cp_create_device_value_dao();
                $deleteDeviceValueRes = $deviceValueDb->deleteDeviceValue(
                    $deviceValueId
		            , $deviceId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteDeviceValueRes)){
                    $dataResponse->dataResponse($deleteDeviceValueRes['Id'], $deleteDeviceValueRes['ErrorCode'], $deleteDeviceValueRes['ErrorMessage'], $deleteDeviceValueRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteDeviceValueRes['ErrorCode'], $deleteDeviceValueRes['ErrorMessage'], $deleteDeviceValueRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
