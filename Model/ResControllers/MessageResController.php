<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/messageDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');

class cp_MessageResController
{
    public function getMessages(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $messageId = null;
        $message = null;
        $type = null;
        $ownerId = null;
        $triggerName = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['MessageId'])){ $messageId = $_GET['MessageId']; };
        if (isset($_GET['Message'])){ $messageAddress = $_GET['Message']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['TriggerName'])){ $triggerName = $_GET['TriggerName']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };
        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };

        //get the json formatted data
        $messageDb = new cp_message_dao();
        $getMessageRes = $messageDb->getMessage(
            $messageId
            , $message
            , $type
            , $ownerId
            , $triggerName
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getMessageRes)){
            $dataResponse->dataResponse($getMessageRes['Data'], $getMessageRes['ErrorCode'], $getMessageRes['ErrorMessage'], $getMessageRes['Error'], $getMessageRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getMessageRes['ErrorCode'], $getMessageRes['ErrorMessage'], $getMessageRes['Error']);
        }
        return;
    }

    public function addMessage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateMessage = json_decode($jsonPost, true);

            $message = null;
            $type = null;
            $ownerId = null;
      	    $triggerName = null;
      	    $enterpriseId = null;

            if (isset($newMessage['Message'])){ $message = $newMessage['Message']; };
            if (isset($newMessage['Type'])){ $type = $newMessage['Type']; };
            if (isset($newMessage['OwnerId'])){ $ownerId = $newMessage['OwnerId']; };
            if (isset($newMessage['TriggerName'])){ $triggerName = $newMessage['TriggerName']; };
            if (isset($newMessage['EnterpriseId'])){ $enterpriseId = $newMessage['EnterpriseId']; };

            //get the json formatted data
            $messageDb = new cp_message_dao();
            $addMessageRes = $messageDb->createMessage(
                $message,
                $type,
                $ownerId,
                $triggerName
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addMessageRes)){
                $dataResponse->dataResponse($addMessageRes['Id'], $addMessageRes['ErrorCode'], $addMessageRes['ErrorMessage'], $addMessageRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addMessageRes['ErrorCode'], $addMessageRes['ErrorMessage'], $addMessageRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateMessage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateMessage = json_decode($jsonPost, true);

            $messageId = null;
            $type = null;
            $message = null;
            $ownerId = null;
            $lastUpdate = null;
      	    $triggerName = null;
      	    $enterpriseId = null;

            if (isset($updateMessage['MessageId'])){ $messageId = $updateMessage['MessageId']; };
            if (isset($updateMessage['Type'])){ $type = $updateMessage['Type']; };
            if (isset($updateMessage['Message'])){ $message = $updateMessage['Message']; };
            if (isset($updateMessage['OwnerId'])){ $ownerId = $updateMessage['OwnerId']; };
            if (isset($updateMessage['LastUpdate'])){ $lastUpdate = $updateMessage['LastUpdate']; };
            if (isset($updateMessage['TriggerName'])){ $triggerName = $updateMessage['TriggerName']; };
            if (isset($updateMessage['EnterpriseId'])){ $triggerName = $updateMessage['EnterpriseId']; };

            //message Id is required for editing the message
            if ($messageId != null){
                //get the json formatted data
                $messageDb = new cp_message_dao();
                $updateMessageRes = $messageDb->updateMessage(
                    $messageId,
                    $message,
                    $type,
                    $lastUpdate,
                    $ownerId,
                    $triggerName
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($updateMessageRes)){
                    $dataResponse->dataResponse($updateMessageRes['Id'], $updateMessageRes['ErrorCode'], $updateMessageRes['ErrorMessage'], $updateMessageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateMessageRes['ErrorCode'], $updateMessageRes['ErrorMessage'], $updateMessageRes['Error']);
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

    public function removeMessage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteMessageValue = json_decode($jsonPost, true);

            $messageId = null;
            $enterpriseId = null;

            if (isset($deleteMessageValue['EnterpriseId'])){ $enterpriseId = $deleteMessageValue['EnterpriseId']; };
            if (isset($deleteMessageValue['MessageId'])){ $messageId = $deleteMessageValue['MessageId']; };

            //message Id is required to delete the message
            if ($messageId != null){
                //get the json formatted data
                $messageDb = new cp_message_dao();
                $deleteMessageRes = $messageDb->deleteMessage(
                    $messageId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteMessageRes)){
                    $dataResponse->dataResponse($deleteMessageRes['Id'], $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeMessageByDeviceId(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteMessageValue = json_decode($jsonPost, true);

            $deviceId = null;
            $enterpriseId = null;

            if (isset($deleteMessageValue['DeviceId'])){ $deviceId = $deleteMessageValue['DeviceId']; };
            if (isset($deleteMessageValue['EnterpriseId'])){ $enterpriseId = $deleteMessageValue['EnterpriseId']; };

            //message Id is required to delete the message
            if ($deviceId != null){
                //get the json formatted data
                $messageDb = new cp_message_dao();
                $deleteMessageRes = $messageDb->deleteMessagebyDeviceId(
                    $deviceId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteMessageRes)){
                    $dataResponse->dataResponse($deleteMessageRes['Id'], $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeMessageByOwnerId(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteMessageValue = json_decode($jsonPost, true);

            $ownerId = null;
            $enterpriseId = null;

            if (isset($deleteMessageValue['OwnerId'])){ $ownerId = $deleteMessageValue['OwnerId']; };
            if (isset($deleteMessageValue['EnterpriseId'])){ $enterpriseId = $deleteMessageValue['EnterpriseId']; };

            //message Id is required to delete the message
            if ($ownerId != null){
                //get the json formatted data
                $messageDb = new cp_message_dao();
                $deleteMessageRes = $messageDb->deleteMessagebyOwnerId(
                    $ownerId
                );
                if ($databaseHelper->hasDataNoError($deleteMessageRes)){
                    $dataResponse->dataResponse($deleteMessageRes['Id'], $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteMessageRes['ErrorCode'], $deleteMessageRes['ErrorMessage'], $deleteMessageRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function getMessagesByEntity(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $messageId = null;
        $message = null;
        $type = null;
        $ownerId = null;
        $triggerName = null;
        $pageSize = null;
        $skipSize = null;
        $limit = null;
        $enterpriseId = null;

        if (isset($_GET['EntityId'])){ $ownerId = $_GET['EntityId']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['Limit'])){ $limit = $_GET['Limit']; };
        if (isset($_GET['EnterpriseId'])){ $limit = $_GET['EnterpriseId']; };

        //get the json formatted data
        $messageDb = new cp_message_dao();
        $getMessageRes = $messageDb->getMessageByEntityId(
            $ownerId
            , $limit //FIX ME!
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getMessageRes)){
            $dataResponse->dataResponse($getMessageRes['Data'], $getMessageRes['ErrorCode'], $getMessageRes['ErrorMessage'], $getMessageRes['Error'], $getMessageRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getMessageRes['ErrorCode'], $getMessageRes['ErrorMessage'], $getMessageRes['Error']);
        }
        return;
    }


}
?>
