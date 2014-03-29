<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipValueDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_DeviceRelationshipValueResController
{
    public function getDeviceRelationshipValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceRelationshipValueId = null;
        $push = null;
        $name = null;
        $sms = null;
        $token  = null;
        $type  = null;
        $resolution  = null;
        $quality  = null;
        $deviceRelationshipId  = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $_GET['DeviceRelationshipValueId']; };
        if (isset($_GET['Name'])){ $push = $_GET['Name']; };
        if (isset($_GET['Push'])){ $push = $_GET['Push']; };
        if (isset($_GET['Sms'])){ $sms = $_GET['Sms']; };
        if (isset($_GET['Token'])){ $token = $_GET['Token']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['Resolution'])){ $resolution = $_GET['Resolution']; };
        if (isset($_GET['Quality'])){ $quality = $_GET['Quality']; };
        if (isset($_GET['DeviceRelationshipId'])){ $deviceRelationshipId = $_GET['DeviceRelationshipId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
        $deviceRelationshipValueRes = $deviceRelationshipValueDb->getDeviceRelationshipValue(
            $deviceRelationshipValueId
            , $name
            , $push
            , $sms
            , $token
            , $type
            , $resolution
            , $quality
            , $deviceRelationshipId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($deviceRelationshipValueRes)){
            $dataResponse->dataResponse($deviceRelationshipValueRes['Data'], $deviceRelationshipValueRes['ErrorCode'], $deviceRelationshipValueRes['ErrorMessage'], $deviceRelationshipValueRes['Error'], $deviceRelationshipValueRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $deviceRelationshipValueRes['ErrorCode'], $deviceRelationshipValueRes['ErrorMessage'], $deviceRelationshipValueRes['Error']);
        }
        return;
    }

    public function addDeviceRelationshipValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newDeviceRelationshipValue = json_decode($jsonPost, true);

            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $salt = null;
            $deviceRelationshipId = null;
            $description = null;
            $enterpriseId = null;

            if (isset($newDeviceRelationshipValue['EnterpriseId'])){ $enterpriseId = $newDeviceRelationshipValue['EnterpriseId']; };
            if (isset($newDeviceRelationshipValue['Push'])){ $push = $newDeviceRelationshipValue['Push']; };
            if (isset($newDeviceRelationshipValue['Sms'])){ $sms = $newDeviceRelationshipValue['Sms']; };
            if (isset($newDeviceRelationshipValue['Token'])){ $token = $newDeviceRelationshipValue['Token']; };
            if (isset($newDeviceRelationshipValue['Type'])){ $type = $newDeviceRelationshipValue['Type']; };
            if (isset($newDeviceRelationshipValue['Resolution'])){ $resolution = $newDeviceRelationshipValue['Resolution']; };
            if (isset($newDeviceRelationshipValue['Quality'])){ $quality = $newDeviceRelationshipValue['Quality']; };
            if (isset($newDeviceRelationshipValue['Hash'])){ $hash = $newDeviceRelationshipValue['Hash']; };
            if (isset($newDeviceRelationshipValue['Salt'])){ $salt = $newDeviceRelationshipValue['Salt']; };
            if (isset($newDeviceRelationshipValue['DeviceRelationshipId'])){ $deviceRelationshipId = $newDeviceRelationshipValue['DeviceRelationshipId']; };
            if (isset($newDeviceRelationshipValue['Description'])){ $description = $newDeviceRelationshipValue['Description']; };

            //get the json formatted data
            $deviceRelationshipValueDb = new cp_create_device_relationship_value_dao();
            $addDeviceRelationshipValueRes = $deviceRelationshipValueDb->createDeviceRelationshipValue(
                $push
                , $sms
                , $token
                , $type
                , $resolution
                , $quality
                , $hash
                , $salt
                , $deviceRelationshipId
                , $description
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addDeviceRelationshipValueRes)){
                $dataResponse->dataResponse($addDeviceRelationshipValueRes['Id'], $addDeviceRelationshipValueRes['ErrorCode'], $addDeviceRelationshipValueRes['ErrorMessage'], $addDeviceRelationshipValueRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addDeviceRelationshipValueRes['ErrorCode'], $addDeviceRelationshipValueRes['ErrorMessage'], $addDeviceRelationshipValueRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateDeviceRelationshipValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceRelationshipValue = json_decode($jsonPost, true);

            $deviceRelationshipValueId = null;
            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $salt = null;
            $lastUpdate = null;
            $deviceRelationshipId = null;
	        $description = null;
	        $enterpriseId = null;

            if (isset($updateDeviceRelationshipValue['EnterpriseId'])){ $enterpriseId = $updateDeviceRelationshipValue['EnterpriseId']; };
            if (isset($updateDeviceRelationshipValue['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $updateDeviceRelationshipValue['DeviceRelationshipValueId']; };
            if (isset($updateDeviceRelationshipValue['Push'])){ $push = $updateDeviceRelationshipValue['Push']; };
            if (isset($updateDeviceRelationshipValue['Sms'])){ $sms = $updateDeviceRelationshipValue['Sms']; };
            if (isset($updateDeviceRelationshipValue['Token'])){ $token = $updateDeviceRelationshipValue['Token']; };
            if (isset($updateDeviceRelationshipValue['Type'])){ $type = $updateDeviceRelationshipValue['Type']; };
            if (isset($updateDeviceRelationshipValue['Resolution'])){ $resolution = $updateDeviceRelationshipValue['Resolution']; };
            if (isset($updateDeviceRelationshipValue['Quality'])){ $quality = $updateDeviceRelationshipValue['Quality']; };
            if (isset($updateDeviceRelationshipValue['Hash'])){ $hash = $updateDeviceRelationshipValue['Hash']; };
            if (isset($updateDeviceRelationshipValue['Salt'])){ $salt = $updateDeviceRelationshipValue['Salt']; };
            if (isset($updateDeviceRelationshipValue['LastUpdate'])){ $lastUpdate = $updateDeviceRelationshipValue['LastUpdate']; };
            if (isset($updateDeviceRelationshipValue['DeviceRelationshipId'])){ $deviceRelationshipId = $updateDeviceRelationshipValue['DeviceRelationshipId']; };
            if (isset($updateDeviceRelationshipValue['Description'])){ $description = $updateDeviceRelationshipValue['Description']; };

            //device Id and entity Id is required for editing the device
            if ($deviceRelationshipValueId != null){
                //get the json formatted data
                $deviceRelationshipValueDb = new cp_create_device_relationship_value_dao();
                $updateDeviceRelationshipValueRes = $deviceRelationshipValueDb->updateDeviceRelationshipValue(
                    $deviceRelationshipValueId
                    , $push
                    , $sms
                    , $token
                    , $type
                    , $resolution
                    , $quality
                    , $hash
                    , $salt
                    , $lastUpdate
                    , $deviceRelationshipId
                    , $description
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($updateDeviceRelationshipValueRes)){
                    $dataResponse->dataResponse($updateDeviceRelationshipValueRes['Id'], $updateDeviceRelationshipValueRes['ErrorCode'], $updateDeviceRelationshipValueRes['ErrorMessage'], $updateDeviceRelationshipValueRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateDeviceRelationshipValueRes['ErrorCode'], $updateDeviceRelationshipValueRes['ErrorMessage'], $updateDeviceRelationshipValueRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, 'Device Relationship Value ID is required', true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeDeviceRelationshipValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteDeviceRelationshipValue = json_decode($jsonPost, true);

            $deviceRelationshipValueId = null;
            $deviceRelationshipId = null;
            $enterpriseId = null;

            if (isset($deleteDeviceRelationshipValue['EnterpriseId'])){ $enterpriseId = $deleteDeviceRelationshipValue['EnterpriseId']; };
            if (isset($deleteDeviceRelationshipValue['DeviceRelationshipId'])){ $deviceRelationshipId = $deleteDeviceRelationshipValue['DeviceRelationshipId']; };
            if (isset($deleteDeviceRelationshipValue['DeviceRelationshipValueId'])){ $deviceRelationshipValueId= $deleteDeviceRelationshipValue['DeviceRelationshipValueId']; };

            //device Id is required to delete the device
            if ($deviceRelationshipValueId != null){
                //get the json formatted data
                $deviceRelationshipValueDb = new cp_create_device_relationship_value_dao();
                $deleteDeviceRelationshipValueRes = $deviceRelationshipValueDb->deleteDeviceRelationshipValue(
                    $deviceRelationshipValueId
		            , $deviceRelationshipId
		            , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipValueRes)){
                    $dataResponse->dataResponse($deleteDeviceRelationshipValueRes['Id'], $deleteDeviceRelationshipValueRes['ErrorCode'], $deleteDeviceRelationshipValueRes['ErrorMessage'], $deleteDeviceRelationshipValueRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteDeviceRelationshipValueRes['ErrorCode'], $deleteDeviceRelationshipValueRes['ErrorMessage'], $deleteDeviceRelationshipValueRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
