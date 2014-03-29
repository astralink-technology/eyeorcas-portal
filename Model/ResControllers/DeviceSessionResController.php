<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceSessionDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_DeviceSessionResController
{

    public function getDeviceSession(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $deviceId = null;
        $connectedDeviceId = null;
        $status = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
        if (isset($_GET['ConnectedDeviceId'])){ $connectedDeviceId = $_GET['ConnectedDeviceId']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };


        //get the json formatted data
        $deviceSessionDb = new cp_device_session_dao();
        $getDeviceSessionRes = $deviceSessionDb->getDeviceSession(
            $deviceId
            , $connectedDeviceId
            , $status
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getDeviceSessionRes)){
            $dataResponse->dataResponse($getDeviceSessionRes['Data'], $getDeviceSessionRes['ErrorCode'], $getDeviceSessionRes['ErrorMessage'], $getDeviceSessionRes['Error'], $getDeviceSessionRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getDeviceSessionRes['ErrorCode'], $getDeviceSessionRes['ErrorMessage'], $getDeviceSessionRes['Error']);
        }
        return;
    }

    public function addDeviceSession(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newDeviceSession = json_decode($jsonPost, true);

            $deviceId = null;
            $connectedDeviceId = null;
            $status = null;
            $enterpriseId = null;

            if (isset($newDeviceSession['EnterpriseId'])){ $enterpriseId = $newDeviceSession['EnterpriseId']; };
            if (isset($newDeviceSession['DeviceId'])){ $deviceId = $newDeviceSession['DeviceId']; };
            if (isset($newDeviceSession['ConnectedDeviceId'])){ $connectedDeviceId = $newDeviceSession['ConnectedDeviceId']; };
            if (isset($newDeviceSession['Status'])){ $status = $newDeviceSession['Status']; };


            //get the json formatted data
            $DeviceSessionDb = new cp_device_session_dao();
            $addDeviceSessionRes = $DeviceSessionDb->createDeviceSession(
                $deviceId,
                $connectedDeviceId,
                $status
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addDeviceSessionRes)){
                $dataResponse->dataResponse($addDeviceSessionRes['Id'], $addDeviceSessionRes['ErrorCode'], $addDeviceSessionRes['ErrorMessage'], $addDeviceSessionRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addDeviceSessionRes['ErrorCode'], $addDeviceSessionRes['ErrorMessage'], $addDeviceSessionRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateDeviceSession(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceSession = json_decode($jsonPost, true);

            $deviceId = null;
            $connectedDeviceId = null;
            $status = null;
            $enterpriseId = null;

            if (isset($updateDeviceSession['EnterpriseId'])){ $enterpriseId = $updateDeviceSession['EnterpriseId']; };
            if (isset($updateDeviceSession['DeviceId'])){ $deviceId = $updateDeviceSession['DeviceId']; };
            if (isset($updateDeviceSession['ConnectedDeviceId'])){ $connectedDeviceId = $updateDeviceSession['ConnectedDeviceId']; };
            if (isset($updateDeviceSession['Status'])){ $status = $updateDeviceSession['Status']; };

            //DeviceSession Id is required for editing the DeviceSession
            if ($deviceId != null){
                //get the json formatted data
                $DeviceSessionDb = new cp_device_session_dao();
                $updateDeviceSessionRes = $DeviceSessionDb->updateDeviceSession(
                    $deviceId,
                    $connectedDeviceId,
                    $status
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($updateDeviceSessionRes)){
                    $dataResponse->dataResponse($updateDeviceSessionRes['Id'], $updateDeviceSessionRes['ErrorCode'], $updateDeviceSessionRes['ErrorMessage'], $updateDeviceSessionRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateDeviceSessionRes['ErrorCode'], $updateDeviceSessionRes['ErrorMessage'], $updateDeviceSessionRes['Error']);
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

    public function removeDeviceSession(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteDeviceSessionValue = json_decode($jsonPost, true);

            $deviceId = null;
            $enterpriseId = null;

            if (isset($deleteDeviceSessionValue['EnterpriseId'])){ $enterpriseId = $deleteDeviceSessionValue['EnterpriseId']; };
            if (isset($deleteDeviceSessionValue['DeviceId'])){ $deviceId = $deleteDeviceSessionValue['DeviceId']; };

            //DeviceSession Id is required to delete the DeviceSession
            if ($deviceId != null){
                //get the json formatted data
                $DeviceSessionDb = new cp_device_session_dao();
                $deleteDeviceSessionRes = $DeviceSessionDb->deleteDeviceSession(
                    $deviceId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteDeviceSessionRes)){
                    $dataResponse->dataResponse($deleteDeviceSessionRes['Id'], $deleteDeviceSessionRes['ErrorCode'], $deleteDeviceSessionRes['ErrorMessage'], $deleteDeviceSessionRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteDeviceSessionRes['ErrorCode'], $deleteDeviceSessionRes['ErrorMessage'], $deleteDeviceSessionRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
    
}
?>
