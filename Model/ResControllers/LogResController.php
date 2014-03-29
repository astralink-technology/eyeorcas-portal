<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/logDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');

class cp_LogResController
{
    public function getLogs(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $logId = null;
        $message = null;
        $title = null;
        $type = null;
        $logUrl = null;
        $status = null;
        $ownerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['LogId'])){ $logId = $_GET['LogId']; };
        if (isset($_GET['Message'])){ $message = $_GET['Message']; };
        if (isset($_GET['Title'])){ $title = $_GET['Title']; };
        if (isset($_GET['Type'])){ $type= $_GET['Type']; };
        if (isset($_GET['LogUrl'])){ $logUrl = $_GET['LogUrl']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $logDb = new cp_log_dao();
        $logRes = $logDb->getLog(
                $logId
                , $message
                , $title
                , $type
                , $logUrl
                , $status
                , $ownerId
                , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($logRes)){
            $dataResponse->dataResponse($logRes['Data'], $logRes['ErrorCode'], $logRes['ErrorMessage'], $logRes['Error'], $logRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $logRes['ErrorCode'], $logRes['ErrorMessage'], $logRes['Error']);
        }
        return;
    }

    public function addLog(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newLog = json_decode($jsonPost, true);
            //$logId = null;
            $message = null;
            $title = null;
            $type = null;
            $logUrl = null;
            $status = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($newLog['EnterpriseId'])){ $enterpriseId  = $newLog['EnterpriseId']; };
            if (isset($newLog['Message'])){ $message = $newLog['Message']; };
            if (isset($newLog['Title'])){ $title = $newLog['Title']; };
            if (isset($newLog['Type'])){ $type = $newLog['Type']; };
            if (isset($newLog['LogUrl'])){ $logUrl = $newLog['LogUrl']; };
            if (isset($newLog['Status'])){ $status = $newLog['Status']; };
            if (isset($newLog['OwnerId'])){ $ownerId = $newLog['OwnerId']; };

            //get the json formatted data
            $logDb = new cp_log_dao();
            $addLogRes = $logDb->createLog(
                $message
                , $title
                , $type
                , $logUrl
                , $status
                , $ownerId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addLogRes)){
                $dataResponse->dataResponse($addLogRes['Id'], $addLogRes['ErrorCode'], $addLogRes['ErrorMessage'], $addLogRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addLogRes['ErrorCode'], $addLogRes['ErrorMessage'], $addLogRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }

    }

    public function updateLog(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateLog = json_decode($jsonPost, true);

            $logId = null;
            $message = null;
            $title = null;
            $type = null;
            $logUrl = null;
            $status = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($updateLog['EnterpriseId'])){ $enterpriseId = $updateLog['EnterpriseId']; };
            if (isset($updateLog['LogId'])){ $logId = $updateLog['LogId']; };
            if (isset($updateLog['Message'])){ $message = $updateLog['Message']; };
            if (isset($updateLog['Title'])){ $title = $updateLog['Title']; };
            if (isset($updateLog['Type'])){ $type = $updateLog['Type']; };
            if (isset($updateLog['LogUrl'])){ $logUrl = $updateLog['LogUrl']; };
            if (isset($updateLog['Status'])){ $status = $updateLog['Status']; };
            if (isset($updateLog['OwnerId'])){ $ownerId = $updateLog['OwnerId']; };


            //log Id and entity Id is required for editing the log
            if ($logId != null && $ownerId != null){
                //get the json formatted data
                $logDb = new cp_log_dao();
                $updateLogRes = $logDb->updateLog(
                    $logId
                    , $message
                    , $title
                    , $type
                    , $logUrl
                    , $status
                    , $ownerId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($updateLogRes)){
                    $dataResponse->dataResponse($updateLogRes['Id'], $updateLogRes['ErrorCode'], $updateLogRes['ErrorMessage'], $updateLogRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateLogRes['ErrorCode'], $updateLogRes['ErrorMessage'], $updateLogRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, 'Log and Entity ID is required', true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeLog(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteLog = json_decode($jsonPost, true);

            $logId = null;
            $enterpriseId = null;

            if (isset($deleteLog['EnterpriseId'])){ $enterpriseId = $deleteLog['EnterpriseId']; };
            if (isset($deleteLog['LogId'])){ $imageId = $deleteLog['LogId']; };

            //log Id is required to delete the log
            if ($logId != null){
                //get the json formatted data
                $logDb = new cp_log_dao();
                $deleteLogRes = $logDb->deleteLog(
                    $logId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteLogRes)){
                    $dataResponse->dataResponse($deleteLogRes['Id'], $deleteLogRes['ErrorCode'], $deleteLogRes['ErrorMessage'], $deleteLogRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteLogRes['ErrorCode'], $deleteLogRes['ErrorMessage'], $deleteLogRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function addLogFromServer(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newLog = json_decode($jsonPost, true);
            //$logId = null;
            $message = null;
            $title = null;
            $type = null;
            $logUrl = null;
            $status = null;
            $entityId  = null;
            $deviceId  = null;
            $deviceCode  = null;


            //if (isset($newLog['LogId'])){ $logId = $newLog['LogId']; };
            if (isset($newLog['Message'])){ $message = $newLog['Message']; };
            if (isset($newLog['Title'])){ $title = $newLog['Title']; };
            if (isset($newLog['Type'])){ $type = $newLog['Type']; };
            if (isset($newLog['LogUrl'])){ $logUrl = $newLog['LogUrl']; };
            if (isset($newLog['Status'])){ $status = $newLog['Status']; };
            if (isset($newLog['EntityId'])){ $entityId = $newLog['EntityId']; };
            if (isset($newLog['DeviceId'])){ $deviceId = $newLog['DeviceId']; };
            if (isset($newLog['DeviceCode'])){ $deviceCode = $newLog['DeviceCode']; };

	    //get the json formatted data
            $deviceDb = new cp_device_dao();
            $getEntityDeviceRes = $deviceDb->getEntityDevice(
                null
                , null
                , $deviceCode
                , null
                , null
                , null
                , null
            );

            if ($databaseHelper->hasDataNoError($getEntityDeviceRes)){
                if ($getEntityDeviceRes["TotalRowsAvailable"] > 0){
                    for($r = 0; $r < $getEntityDeviceRes['TotalRowsAvailable']; $r++){
                        $entityId = $getEntityDeviceRes["Data"][$r]->entityId;
                        $deviceId = $getEntityDeviceRes["Data"][$r]->deviceId;
                        if ($deviceId != null){
			    $logDb = new cp_log_dao();
			    $addLogRes = $logDb->createLog(
				$message
				, $title
				, $type
				, $logUrl
				, $status
				, $entityId
				, $deviceId
			    );

			    if ($databaseHelper->hasDataNoError($addLogRes)){
				$dataResponse->dataResponse($addLogRes['Id'], $addLogRes['ErrorCode'], $addLogRes['ErrorMessage'], $addLogRes['Error']);
			    }else{
				$dataResponse->dataResponse(null, $addLogRes['ErrorCode'], $addLogRes['ErrorMessage'], $addLogRes['Error']);
				return;
			    }
                            //
                        }else{
                            $dataResponse->dataResponse(null, -1, "Failed to add Log", true);
                            return;
                        }
			//error_log($r);
                    }
                }else{
                    $dataResponse->dataResponse(null, -1, "No Device Found", true);
                    return;
                }
            }else{

            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }

    }
    
}
?>
