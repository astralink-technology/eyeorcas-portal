<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/emailDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_EmailResController
{
    public function getEmails(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $emailId = null;
        $emailAddress = null;
        $ownerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['EmailId'])){ $emailId = $_GET['EmailId']; };
        if (isset($_GET['EmailAddress'])){ $emailAddress = $_GET['EmailAddress']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $emailDb = new cp_email_dao();
        $getEmailRes = $emailDb->getEmail(
            $emailId
            , $emailAddress
            , $ownerId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getEmailRes)){
            $dataResponse->dataResponse($getEmailRes['Data'], $getEmailRes['ErrorCode'], $getEmailRes['ErrorMessage'], $getEmailRes['Error'], $getEmailRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getEmailRes['ErrorCode'], $getEmailRes['ErrorMessage'], $getEmailRes['Error']);
        }
        return;
    }

    public function addEmail(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateEmail = json_decode($jsonPost, true);

            $emailAddress = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($newEmail['EmailAddress'])){ $emailAddress = $newEmail['EmailAddress']; };
            if (isset($newEmail['OwnerId'])){ $ownerId = $newEmail['OwnerId']; };
            if (isset($newEmail['EnterpriseId'])){ $enterpriseId = $newEmail['EnterpriseId']; };

            //get the json formatted data
            $emailDb = new cp_email_dao();
            $addEmailRes = $emailDb->createEmail(
                $emailAddress,
                $ownerId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addEmailRes)){
                $dataResponse->dataResponse($addEmailRes['Id'], $addEmailRes['ErrorCode'], $addEmailRes['ErrorMessage'], $addEmailRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addEmailRes['ErrorCode'], $addEmailRes['ErrorMessage'], $addEmailRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateEmail(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateEmail = json_decode($jsonPost, true);

            $emailId = null;
            $emailAddress = null;
            $ownerId = null;
            $lastUpdate = null;
            $enterpriseId = null;

            if (isset($updateEmail['EnterpriseId'])){ $enterpriseId = $updateEmail['EnterpriseId']; };
            if (isset($updateEmail['EmailId'])){ $emailId = $updateEmail['EmailId']; };
            if (isset($updateEmail['EmailAddress'])){ $emailAddress = $updateEmail['EmailAddress']; };
            if (isset($updateEmail['OwnerId'])){ $ownerId = $updateEmail['OwnerId']; };
            if (isset($updateEmail['LastUpdate'])){ $lastUpdate = $updateEmail['LastUpdate']; };

            //email Id is required for editing the email
            if ($emailId != null){
                //get the json formatted data
                $emailDb = new cp_email_dao();
                $updateEmailRes = $emailDb->updateEmail(
                    $emailId,
                    $emailAddress,
                    $ownerId,
                    $lastUpdate
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($updateEmailRes)){
                    $dataResponse->dataResponse($updateEmailRes['Id'], $updateEmailRes['ErrorCode'], $updateEmailRes['ErrorMessage'], $updateEmailRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateEmailRes['ErrorCode'], $updateEmailRes['ErrorMessage'], $updateEmailRes['Error']);
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

    public function removeEmail(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteEmailValue = json_decode($jsonPost, true);

            $enterpriseId = null;
            $emailId = null;

            if (isset($deleteEmailValue['EnterpriseId'])){ $enterpriseId = $deleteEmailValue['EnterpriseId']; };
            if (isset($deleteEmailValue['EmailId'])){ $emailId = $deleteEmailValue['EmailId']; };

            //email Id is required to delete the email
            if ($emailId != null){
                //get the json formatted data
                $emailDb = new cp_email_dao();
                $deleteEmailRes = $emailDb->deleteEmail(
                    $emailId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteEmailRes)){
                    $dataResponse->dataResponse($deleteEmailRes['Id'], $deleteEmailRes['ErrorCode'], $deleteEmailRes['ErrorMessage'], $deleteEmailRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteEmailRes['ErrorCode'], $deleteEmailRes['ErrorMessage'], $deleteEmailRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
