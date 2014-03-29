<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/encryption_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipValueDao.php');

class cp_DeviceRelationshipResController
{
    public function getDeviceRelationships(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceRelationshipId = null;
        $deviceId = null;
        $ownerId  = null;
        $messageTriggerEvent = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId= $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceRelationshipId'])){ $deviceRelationshipId = $_GET['DeviceRelationshipId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $getDeviceRelationshipRes = $deviceRelationshipDb->getDeviceRelationship(
            $deviceRelationshipId
            , $deviceId
            , $ownerId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($getDeviceRelationshipRes)){
            $dataResponse->dataResponse($getDeviceRelationshipRes['Data'], $getDeviceRelationshipRes['ErrorCode'], $getDeviceRelationshipRes['ErrorMessage'], $getDeviceRelationshipRes['Error'], $getDeviceRelationshipRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getDeviceRelationshipRes['ErrorCode'], $getDeviceRelationshipRes['ErrorMessage'], $getDeviceRelationshipRes['Error']);
        }
        return;
    }

    public function getDeviceRelationshipMedia(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $mediaId = null;
        $type = null;
        $status = null;
        $ownerId = null;
        $deviceId = null;
        $deviceRelationshipId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId= $_GET['EnterpriseId']; };
        if (isset($_GET['MediaId'])){ $mediaId = $_GET['MediaId']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['DeviceRelationshipId'])){ $deviceRelationshipId = $_GET['DeviceRelationshipId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $deviceRelationshipMediaRes = $deviceRelationshipDb->getDeviceRelationshipMedia(
            $mediaId
            , $type
            , $status
            , $ownerId
            , $deviceId
            , $deviceRelationshipId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($deviceRelationshipMediaRes)){
            $dataResponse->dataResponse($deviceRelationshipMediaRes['Data'], $deviceRelationshipMediaRes['ErrorCode'], $deviceRelationshipMediaRes['ErrorMessage'], $deviceRelationshipMediaRes['Error'], $deviceRelationshipMediaRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $deviceRelationshipMediaRes['ErrorCode'], $deviceRelationshipMediaRes['ErrorMessage'], $deviceRelationshipMediaRes['Error']);
        }
        return;
    }

    /* Getting devices from relationship */
    public function getEntityDeviceRelationship(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceId = null;
        $name = null;
        $code = null;
        $status = null;
        $type = null;
        $type2 = null;
        $ownerId  = null;
        $pageSize  = null;
        $skipSize  = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId= $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['Name'])){ $name = $_GET['Name']; };
        if (isset($_GET['Code'])){ $code = $_GET['Code']; };
        if (isset($_GET['Status'])){ $status= $_GET['Status']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['Type2'])){ $type2 = $_GET['Type2']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSizs'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $deviceRes = $deviceRelationshipDb->getEntityDeviceRelationship(
            $deviceId
            , $ownerId
            , $name
            , $code
            , $status
            , $type
            , $type2
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($deviceRes)){
            $dataResponse->dataResponse($deviceRes['Data'], $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error'], $deviceRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error']);
        }
        return;
    }



    /* Getting devices from relationship */
    public function getEntityDeviceRelationshipDetails(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceId = null;
        $ownerId = null;
        $deviceName = null;
        $deviceCode = null;
        $deviceStatus = null;
        $deviceType = null;
        $deviceType2 = null;
        $deviceRelationshipName = null;
        $deviceRelationshipPush = null;
        $deviceRelationshipSms = null;
        $deviceRelationshipToken = null;
        $deviceRelationshipResolution = null;
        $deviceRelationshipQuality = null;
        $deviceRelationshipType = null;
        $pageSize  = null;
        $skipSize  = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId= $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['DeviceName'])){ $deviceName = $_GET['DeviceName']; };
        if (isset($_GET['DeviceCode'])){ $deviceCode= $_GET['DeviceCode']; };
        if (isset($_GET['DeviceStatus'])){ $deviceStatus = $_GET['DeviceStatus']; };
        if (isset($_GET['DeviceType'])){ $deviceType = $_GET['DeviceType']; };
        if (isset($_GET['DeviceType2'])){ $deviceType2 = $_GET['DeviceType2']; };
        if (isset($_GET['DeviceRelationshipName'])){ $deviceRelationshipName = $_GET['DeviceRelationshipName']; };
        if (isset($_GET['DeviceRelationshipPush'])){ $deviceRelationshipPush = $_GET['DeviceRelationshipPush']; };
        if (isset($_GET['DeviceRelationshipSms'])){ $deviceRelationshipSms = $_GET['DeviceRelationshipSms']; };
        if (isset($_GET['DeviceRelationshipToken'])){ $deviceRelationshipToken = $_GET['DeviceRelationshipToken']; };
        if (isset($_GET['DeviceRelationshipResolution'])){ $deviceRelationshipResolution = $_GET['DeviceRelationshipResolution']; };
        if (isset($_GET['DeviceRelationshipQuality'])){ $deviceRelationshipQuality = $_GET['DeviceRelationshipQuality']; };
        if (isset($_GET['DeviceRelationshipType'])){ $deviceRelationshipType = $_GET['DeviceRelationshipType']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $entityDeviceRelationshipRes = $deviceRelationshipDb->getEntityDeviceRelationshipValue(
            $deviceId
            , $ownerId
            , $deviceName
            , $deviceCode
            , $deviceStatus
            , $deviceType
            , $deviceType2
            , $deviceRelationshipName
            , $deviceRelationshipPush
            , $deviceRelationshipSms
            , $deviceRelationshipToken
            , $deviceRelationshipResolution
            , $deviceRelationshipQuality
            , $deviceRelationshipType
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($entityDeviceRelationshipRes)){
            $dataResponse->dataResponse($entityDeviceRelationshipRes['Data'], $entityDeviceRelationshipRes['ErrorCode'], $entityDeviceRelationshipRes['ErrorMessage'], $entityDeviceRelationshipRes['Error'], $entityDeviceRelationshipRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $entityDeviceRelationshipRes['ErrorCode'], $entityDeviceRelationshipRes['ErrorMessage'], $entityDeviceRelationshipRes['Error']);
        }
        return;
    }

    public function addEntityDeviceRelationshipWithValues(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newEntityDeviceRelationshipWithValue = json_decode($jsonPost, true);

            $deviceName = null;
            $deviceCode = null;
            $deviceStatus = null;
            $deviceType = null;
            $deviceType2 = null;
            $deviceDescription = null;
            $deviceOwnerId = null;
            $ownerId = null;
            $name = null;
            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $password = null;
            $description = null;
            $deviceId = null;
            $ownerId  = null;

            $hash = null;
            $enterpriseId = null;

            if (isset($newEntityDeviceRelationshipWithValue['EnterpriseId'])){ $enterpriseId = $newEntityDeviceRelationshipWithValue['EnterpriseId']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceName'])){ $deviceName = $newEntityDeviceRelationshipWithValue['DeviceName']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceCode'])){ $deviceCode = $newEntityDeviceRelationshipWithValue['DeviceCode']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceStatus'])){ $deviceStatus = $newEntityDeviceRelationshipWithValue['DeviceStatus']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceType'])){ $deviceType= $newEntityDeviceRelationshipWithValue['DeviceType']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceType2'])){ $deviceType2 = $newEntityDeviceRelationshipWithValue['DeviceType2']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceDescription'])){ $deviceDescription= $newEntityDeviceRelationshipWithValue['DeviceDescription']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceOwnerId'])){ $deviceOwnerId = $newEntityDeviceRelationshipWithValue['DeviceOwnerId']; };
            if (isset($newEntityDeviceRelationshipWithValue['OwnerId'])){ $ownerId = $newEntityDeviceRelationshipWithValue['OwnerId']; };
            if (isset($newEntityDeviceRelationshipWithValue['Name'])){ $name = $newEntityDeviceRelationshipWithValue['Name']; };
            if (isset($newEntityDeviceRelationshipWithValue['Push'])){ $push = $newEntityDeviceRelationshipWithValue['Push']; };
            if (isset($newEntityDeviceRelationshipWithValue['Sms'])){ $sms = $newEntityDeviceRelationshipWithValue['Sms']; };
            if (isset($newEntityDeviceRelationshipWithValue['Token'])){ $token = $newEntityDeviceRelationshipWithValue['Token']; };
            if (isset($newEntityDeviceRelationshipWithValue['Type'])){ $type = $newEntityDeviceRelationshipWithValue['Type']; };
            if (isset($newEntityDeviceRelationshipWithValue['Resolution'])){ $resolution = $newEntityDeviceRelationshipWithValue['Resolution']; };
            if (isset($newEntityDeviceRelationshipWithValue['Quality'])){ $quality = $newEntityDeviceRelationshipWithValue['Quality']; };
            if (isset($newEntityDeviceRelationshipWithValue['Password'])){ $password = $newEntityDeviceRelationshipWithValue['Password']; };
            if (isset($newEntityDeviceRelationshipWithValue['Description'])){ $description= $newEntityDeviceRelationshipWithValue['Description']; };
            if (isset($newEntityDeviceRelationshipWithValue['DeviceId'])){ $deviceId = $newEntityDeviceRelationshipWithValue['DeviceId']; };
            if (isset($newEntityDeviceRelationshipWithValue['OwnerId'])){ $ownerId = $newEntityDeviceRelationshipWithValue['OwnerId']; };

            if ($password != null){
                $encryptionUtils = new cp_encryption_helper();
                $hash = $encryptionUtils->hash($password);
            }

            //get the json formatted data
            $deviceRelationshipDb = new cp_device_relationship_dao();
            $addEntityDeviceRelationshipValueRes = $deviceRelationshipDb->createEntityDeviceRelationshipWithValue(
                $deviceName
                , $deviceCode
                , $deviceStatus
                , $deviceType
                , $deviceType2
                , $deviceDescription
                , $deviceOwnerId
                , $ownerId
                , $name
                , $push
                , $sms
                , $token
                , $type
                , $resolution
                , $quality
                , $hash
                , null
                , $description
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addEntityDeviceRelationshipValueRes)){
                $dataResponse->dataResponse($addEntityDeviceRelationshipValueRes['Id'], $addEntityDeviceRelationshipValueRes['ErrorCode'], $addEntityDeviceRelationshipValueRes['ErrorMessage'], $addEntityDeviceRelationshipValueRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addEntityDeviceRelationshipValueRes['ErrorCode'], $addEntityDeviceRelationshipValueRes['ErrorMessage'], $addEntityDeviceRelationshipValueRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function addDeviceRelationship(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newDeviceRelationship = json_decode($jsonPost, true);

            $deviceId = null;
            $ownerId  = null;
            $enterpriseId = null;

            if (isset($newDeviceRelationship['EnterpriseId'])){ $enterpriseId = $newDeviceRelationship['EnterpriseId']; };
            if (isset($newDeviceRelationship['DeviceId'])){ $deviceId = $newDeviceRelationship['DeviceId']; };
            if (isset($newDeviceRelationship['OwnerId'])){ $ownerId = $newDeviceRelationship['OwnerId']; };

            //get the json formatted data
            $deviceRelationshipDb = new cp_device_relationship_dao();
            $addDeviceRelationshipRes = $deviceRelationshipDb->createDeviceRelationship(
                $deviceId
                , $ownerId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addDeviceRelationshipRes)){
                $dataResponse->dataResponse($addDeviceRelationshipRes['Id'], $addDeviceRelationshipRes['ErrorCode'], $addDeviceRelationshipRes['ErrorMessage'], $addDeviceRelationshipRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addDeviceRelationshipRes['ErrorCode'], $addDeviceRelationshipRes['ErrorMessage'], $addDeviceRelationshipRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateDeviceRelationship(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceRelationship = json_decode($jsonPost, true);
            $deviceRelationshipId = null;
            $deviceId = null;
            $ownerId  = null;
            $lastUpdate = null;
            $enterpriseId = null;

            if (isset($updateDeviceRelationship['EnterpriseId'])){ $enterpriseId = $updateDeviceRelationship['EnterpriseId']; };
            if (isset($updateDeviceRelationship['DeviceRelationshipId'])){ $deviceRelationshipId = $updateDeviceRelationship['DeviceRelationshipId']; };
            if (isset($updateDeviceRelationship['DeviceId'])){ $deviceId = $updateDeviceRelationship['DeviceId']; };
            if (isset($updateDeviceRelationship['OwnerId'])){ $ownerId = $updateDeviceRelationship['OwnerId']; };
            if (isset($updateDeviceRelationship['LastUpdate'])){ $lastUpdate = $updateDeviceRelationship['LastUpdate']; };

            //get the json formatted data
            $deviceRelationshipDb = new cp_device_relationship_dao();
            $updateDeviceRelationshipRes = $deviceRelationshipDb->updateDeviceRelationship(
                $deviceRelationshipId
                , $deviceId
                , $ownerId
                , $lastUpdate
                , $enterpriseId
            );
            if ($databaseHelper->hasDataNoError($updateDeviceRelationshipRes)){
                $dataResponse->dataResponse($updateDeviceRelationshipRes['Id'], $updateDeviceRelationshipRes['ErrorCode'], $updateDeviceRelationshipRes['ErrorMessage'], $updateDeviceRelationshipRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $updateDeviceRelationshipRes['ErrorCode'], $updateDeviceRelationshipRes['ErrorMessage'], $updateDeviceRelationshipRes['Error']);
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateDeviceAndDeviceRelationshipWithValues(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceAndDeviceRelationshipWithValues = json_decode($jsonPost, true);

            $deviceId = null;
            $deviceOwnerId = null;
            $deviceRelationshipId = null;
            $deviceRelationshipValueId = null;

            //device variables
            $deviceName = null;
            $deviceCode = null;
            $deviceStatus = null;
            $deviceType = null;
            $deviceType2 = null;
            $deviceDescription = null;
            $deviceLastUpdate = null;

            //device relationship value variables
            $name = null;
            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $description = null;
            $password = null;
            $deviceRelationshipValueLastUpdate = null;
            $enterpriseId = null;

            if (isset($updateDeviceAndDeviceRelationshipWithValues['EnterpriseId'])){ $enterpriseId = $updateDeviceAndDeviceRelationshipWithValues['EnterpriseId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceId'])){ $deviceId = $updateDeviceAndDeviceRelationshipWithValues['DeviceId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceOwnerId'])){ $deviceOwnerId = $updateDeviceAndDeviceRelationshipWithValues['DeviceOwnerId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipId'])){ $deviceRelationshipId = $updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceName'])){ $deviceName= $updateDeviceAndDeviceRelationshipWithValues['DeviceName']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceCode'])){ $deviceCode = $updateDeviceAndDeviceRelationshipWithValues['DeviceCode']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceStatus'])){ $deviceStatus = $updateDeviceAndDeviceRelationshipWithValues['DeviceStatus']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceType'])){ $deviceType = $updateDeviceAndDeviceRelationshipWithValues['DeviceType']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceType2'])){ $deviceType2 = $updateDeviceAndDeviceRelationshipWithValues['DeviceType2']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceDescription'])){ $deviceDescription = $updateDeviceAndDeviceRelationshipWithValues['DeviceDescription']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceLastUpdate'])){ $deviceDescription = $updateDeviceAndDeviceRelationshipWithValues['DeviceLastUpdate']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueLastUpdate'])){ $deviceRelationshipValueLastUpdate = $updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueLastUpdate']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Push'])){ $push = $updateDeviceAndDeviceRelationshipWithValues['Push']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Name'])){ $name = $updateDeviceAndDeviceRelationshipWithValues['Name']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Sms'])){ $sms = $updateDeviceAndDeviceRelationshipWithValues['Sms']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Token'])){ $token = $updateDeviceAndDeviceRelationshipWithValues['Token']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Type'])){ $type = $updateDeviceAndDeviceRelationshipWithValues['Type']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Resolution'])){ $resolution = $updateDeviceAndDeviceRelationshipWithValues['Resolution']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Quality'])){ $quality = $updateDeviceAndDeviceRelationshipWithValues['Quality']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Password'])){ $password = $updateDeviceAndDeviceRelationshipWithValues['Password']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Description'])){ $description = $updateDeviceAndDeviceRelationshipWithValues['Description']; };

            $deviceDb = new cp_device_dao();
            $deviceRelationshipValueDb = new cp_device_relationship_value_dao();

            $encryptionUtils = new cp_encryption_helper();
            if ($password != null){
                $hash = $encryptionUtils->hash($password);
            }

            //update the device
            $updateDeviceRes = $deviceDb->updateDevice(
                $deviceId
                , $deviceName
                , $deviceCode
                , $deviceStatus
                , $deviceType
                , $deviceType2
                , $deviceDescription
                , $deviceLastUpdate
                , $deviceOwnerId
                , $enterpriseId
            );
            if ($databaseHelper->hasDataNoError($updateDeviceRes)){
                //update the device relationship value
                $updateDeviceValueRes = $deviceRelationshipValueDb->updateDeviceRelationshipValue(
                    $deviceRelationshipValueId
                    , $name
                    , $push
                    , $sms
                    , $token
                    , $type
                    , $resolution
                    , $quality
                    , $hash
                    , null
                    , $deviceRelationshipValueLastUpdate
                    , $deviceRelationshipId
                    , $description
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($updateDeviceValueRes)){
                    $dataResponse->dataResponse($updateDeviceValueRes['Id'], $updateDeviceValueRes['ErrorCode'], $updateDeviceValueRes['ErrorMessage'], $updateDeviceValueRes['Error']);
                    return;
                }else{
                    $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                    return;
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeEntityDeviceRelationshipWithValues(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteEntityDeviceRelationshipWithValues = json_decode($jsonPost, true);

            $deviceRelationshipId = null;
            $deviceRelationshipValueId =  null;
            $enterpriseId = null;

            if (isset($deleteEntityDeviceRelationshipWithValues['EnterpriseId'])){ $enterpriseId = $deleteEntityDeviceRelationshipWithValues['EnterpriseId']; };
            if (isset($deleteEntityDeviceRelationshipWithValues['DeviceRelationshipId'])){ $deviceRelationshipId = $deleteEntityDeviceRelationshipWithValues['DeviceRelationshipId']; };
            if (isset($deleteEntityDeviceRelationshipWithValues['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $deleteEntityDeviceRelationshipWithValues['DeviceRelationshipValueId']; };

            //device Id is required to delete the device
            if ($deviceRelationshipId != null && $deviceRelationshipValueId != null){
                //get the json formatted data
                $deviceRelationshipDb = new cp_device_relationship_dao();
                $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
                $deleteDeviceRelationshipRes = $deviceRelationshipDb->deleteDeviceRelationship(
                    $deviceRelationshipId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipRes)){
                    $deleteDeviceRelationshipValueRes = $deviceRelationshipValueDb->deleteDeviceRelationshipValue(
                        $deviceRelationshipValueId
                    );
                    if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipValueRes)){
                        $dataResponse->dataResponse($deleteDeviceRelationshipRes['Id'], $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
                        return;
                    }else{
                        $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                        return;
                    }
                }else{
                    $dataResponse->dataResponse(null, $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeDeviceRelationship(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteDeviceRelationship = json_decode($jsonPost, true);

            $deviceRelationshipId = null;
            $enterpriseId = null;

            if (isset($deleteDeviceRelationship['EnterpriseId'])){ $enterpriseId = $deleteDeviceRelationship['EnterpriseId']; };
            if (isset($deleteDeviceRelationship['DeviceRelationshipId'])){ $deviceRelationshipId = $deleteDeviceRelationship['DeviceRelationshipId']; };

            //device Id is required to delete the device
            if ($deviceRelationshipId != null){
                //get the json formatted data
                $deviceRelationshipDb = new cp_device_relationship_dao();
                $deleteDeviceRelationshipRes = $deviceRelationshipDb->deleteDeviceRelationship(
                    $deviceRelationshipId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipRes)){
                    $dataResponse->dataResponse($deleteDeviceRelationshipRes['Id'], $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
