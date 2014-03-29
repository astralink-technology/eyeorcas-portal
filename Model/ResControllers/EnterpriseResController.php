<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/enterpriseDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_EnterpriseResController
{
    public function getEnterprises(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $enterpriseId = null;
        $name = null;
        $code = null;
        $pageSize = null;
        $skipSize = null;
        $strict = null;
        $targetEnterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['TargetEnterpriseId'])){ $targetEnterpriseId = $_GET['TargetEnterpriseId']; };
        if (isset($_GET['Name'])){ $name = $_GET['Name']; };
        if (isset($_GET['Code'])){ $code = $_GET['Code']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };
        if (isset($_GET['Strict'])){ $strict = $_GET['Strict']; };

        //get the json formatted data
        $enterpriseDb = new cp_enterprise_dao();
        $getEnterpriseRes = $enterpriseDb->getEnterprise(
            $enterpriseId
            , $name
            , $code
            , $pageSize
            , $skipSize
            , $targetEnterpriseId
        );

        if ($databaseHelper->hasDataNoError($getEnterpriseRes)){
            $dataResponse->dataResponse($getEnterpriseRes['Data'], $getEnterpriseRes['ErrorCode'], $getEnterpriseRes['ErrorMessage'], $getEnterpriseRes['Error'], $getEnterpriseRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getEnterpriseRes['ErrorCode'], $getEnterpriseRes['ErrorMessage'], $getEnterpriseRes['Error']);
        }
        return;
    }

    public function addEnterprise(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newEnterprise = json_decode($jsonPost, true);

            $name = null;
            $code = null;
            $description = null;
            $targetEnterpriseId = null;

            if (isset($newEnterprise['Name'])){ $name = $newEnterprise['Name']; };
            if (isset($newEnterprise['Code'])){ $code = $newEnterprise['Code']; };
            if (isset($newEnterprise['Description'])){ $description = $newEnterprise['Description']; };
            if (isset($newEnterprise['TargetEnterpriseId'])){ $targetEnterpriseId = $newEnterprise['TargetEnterpriseId']; };

            //get the json formatted data
            $enterpriseDb = new cp_enterprise_dao();
            $addEnterpriseRes = $enterpriseDb->createEnterprise(
                $name
                , $code
                , $description
                , $targetEnterpriseId
            );

            if ($databaseHelper->hasDataNoError($addEnterpriseRes)){
                $dataResponse->dataResponse($addEnterpriseRes['Id'], $addEnterpriseRes['ErrorCode'], $addEnterpriseRes['ErrorMessage'], $addEnterpriseRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addEnterpriseRes['ErrorCode'], $addEnterpriseRes['ErrorMessage'], $addEnterpriseRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateEnterprise(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateEnterprise = json_decode($jsonPost, true);

            $enterpriseId = null;
            $name = null;
            $code = null;
            $description = null;
            $lastUpdate = null;
            $targetEnterpriseId = null;

            if (isset($updateEnterprise['TargetEnterpriseId'])){ $targetEnterpriseId = $updateEnterprise['TargetEnterpriseId']; };
            if (isset($updateEnterprise['PhoneId'])){ $enterpriseId = $updateEnterprise['PhoneId']; };
            if (isset($updateEnterprise['PhoneDigits'])){ $name = $updateEnterprise['PhoneDigits']; };
            if (isset($updateEnterprise['Digits'])){ $code = $updateEnterprise['Digits']; };
            if (isset($updateEnterprise['CountryCode'])){ $description = $updateEnterprise['CountryCode']; };
            if (isset($updateEnterprise['Code'])){ $lastUpdate = $updateEnterprise['Code']; };

            //phone Id is required for editing the phone
            if ($enterpriseId != null){
                //get the json formatted data
                $enterpriseDb = new cp_enterprise_dao();
                $updateEnterpriseRes = $enterpriseDb->updateEnterprise(
                    $enterpriseId
                    , $name
                    , $code
                    , $description
                    , $lastUpdate
                    , $targetEnterpriseId
                );

                if ($databaseHelper->hasDataNoError($updateEnterpriseRes)){
                    $dataResponse->dataResponse($updateEnterpriseRes['Id'], $updateEnterpriseRes['ErrorCode'], $updateEnterpriseRes['ErrorMessage'], $updateEnterpriseRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateEnterpriseRes['ErrorCode'], $updateEnterpriseRes['ErrorMessage'], $updateEnterpriseRes['Error']);
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

    public function removeEnterprise(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteEnterprise = json_decode($jsonPost, true);

            $enterpriseId = null;
            $targetEnterpriseId = null;

            if (isset($deleteEnterprise['EnterpriseId'])){ $enterpriseId = $deleteEnterprise['EnterpriseId']; };
            if (isset($deleteEnterprise['TargetEnterpriseId'])){ $targetEnterpriseId = $deleteEnterprise['TargetEnterpriseId']; };

            //phone Id is required to delete the phone
            if ($enterpriseId != null){
                //get the json formatted data
                $enterpriseDb = new cp_enterprise_dao();
                $deleteEnterpriseRes = $enterpriseDb->deleteEnterprise(
                    $enterpriseId
                    , $targetEnterpriseId
                );

                if ($databaseHelper->hasDataNoError($deleteEnterpriseRes)){
                    $dataResponse->dataResponse($deleteEnterpriseRes['Id'], $deleteEnterpriseRes['ErrorCode'], $deleteEnterpriseRes['ErrorMessage'], $deleteEnterpriseRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteEnterpriseRes['ErrorCode'], $deleteEnterpriseRes['ErrorMessage'], $deleteEnterpriseRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
