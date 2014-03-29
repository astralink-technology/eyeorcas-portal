<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/phoneDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_PhoneResController
{
    public function getPhones(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $phoneId = null;
        $phoneDigits = null;
        $digits = null;
        $countryCode = null;
        $code = null;
        $ownerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['PhoneId'])){ $phoneId = $_GET['PhoneId']; };
        if (isset($_GET['CountryCode'])){ $countryCode = $_GET['CountryCode']; };
        if (isset($_GET['PhoneDigits'])){ $phoneDigits = $_GET['PhoneDigits']; };
        if (isset($_GET['Digits'])){ $digits = $_GET['Digits']; };
        if (isset($_GET['Code'])){ $code = $_GET['Code']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $phoneDb = new cp_phone_dao();
        $getPhoneRes = $phoneDb->getPhone(
            $phoneId
            , $phoneDigits
            , $digits
            , $countryCode
            , $code
            , $ownerId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getPhoneRes)){
            $dataResponse->dataResponse($getPhoneRes['Data'], $getPhoneRes['ErrorCode'], $getPhoneRes['ErrorMessage'], $getPhoneRes['Error'], $getPhoneRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getPhoneRes['ErrorCode'], $getPhoneRes['ErrorMessage'], $getPhoneRes['Error']);
        }
        return;
    }

    public function addPhone(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newPhone = json_decode($jsonPost, true);

            $phoneDigits = null;
            $digits = null;
            $countryCode = null;
            $code = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($newPhone['EnterpriseId'])){ $enterpriseId = $newPhone['EnterpriseId']; };
            if (isset($newPhone['PhoneDigits'])){ $phoneDigits = $newPhone['PhoneDigits']; };
            if (isset($newPhone['Digits'])){ $digits = $newPhone['Digits']; };
            if (isset($newPhone['CountryCode'])){ $countryCode = $newPhone['CountryCode']; };
            if (isset($newPhone['Code'])){ $code = $newPhone['Code']; };
            if (isset($newPhone['OwnerId'])){ $ownerId = $newPhone['OwnerId']; };

            //get the json formatted data
            $phoneDb = new cp_phone_dao();
            $addPhoneRes = $phoneDb->createPhone(
                $phoneDigits,
                $digits,
                $countryCode,
                $code,
                $enterpriseId
                , $ownerId
            );

            if ($databaseHelper->hasDataNoError($addPhoneRes)){
                $dataResponse->dataResponse($addPhoneRes['Id'], $addPhoneRes['ErrorCode'], $addPhoneRes['ErrorMessage'], $addPhoneRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addPhoneRes['ErrorCode'], $addPhoneRes['ErrorMessage'], $addPhoneRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updatePhone(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updatePhone = json_decode($jsonPost, true);

            $phoneId = null;
            $phoneDigits = null;
            $digits = null;
            $countryCode = null;
            $code = null;
            $lastUpdate = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($updatePhone['PhoneId'])){ $phoneId = $updatePhone['PhoneId']; };
            if (isset($updatePhone['PhoneDigits'])){ $phoneDigits = $updatePhone['PhoneDigits']; };
            if (isset($updatePhone['Digits'])){ $digits = $updatePhone['Digits']; };
            if (isset($updatePhone['CountryCode'])){ $countryCode = $updatePhone['CountryCode']; };
            if (isset($updatePhone['Code'])){ $code = $updatePhone['Code']; };
            if (isset($updatePhone['OwnerId'])){ $ownerId = $updatePhone['OwnerId']; };
            if (isset($updatePhone['LastUpdate'])){ $lastUpdate = $updatePhone['LastUpdate']; };
            if (isset($updatePhone['EnterpriseId'])){ $enterpriseId = $updatePhone['EnterpriseId']; };

            //phone Id is required for editing the phone
            if ($phoneId != null){
                //get the json formatted data
                $phoneDb = new cp_phone_dao();
                $updatePhoneRes = $phoneDb->updatePhone(
                    $phoneId,
                    $phoneDigits,
                    $digits,
                    $countryCode,
                    $code,
                    $lastUpdate,
                    $ownerId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($updatePhoneRes)){
                    $dataResponse->dataResponse($updatePhoneRes['Id'], $updatePhoneRes['ErrorCode'], $updatePhoneRes['ErrorMessage'], $updatePhoneRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updatePhoneRes['ErrorCode'], $updatePhoneRes['ErrorMessage'], $updatePhoneRes['Error']);
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

    public function removePhone(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deletePhoneValue = json_decode($jsonPost, true);

            $phoneId = null;
            $enterpriseId = null;
            if (isset($deletePhoneValue['EnterpriseId'])){ $enterpriseId = $deletePhoneValue['EnterpriseId']; };
            if (isset($deletePhoneValue['PhoneId'])){ $phoneId = $deletePhoneValue['PhoneId']; };

            //phone Id is required to delete the phone
            if ($phoneId != null){
                //get the json formatted data
                $phoneDb = new cp_phone_dao();
                $deletePhoneRes = $phoneDb->deletePhone(
                    $phoneId
                    , null
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deletePhoneRes)){
                    $dataResponse->dataResponse($deletePhoneRes['Id'], $deletePhoneRes['ErrorCode'], $deletePhoneRes['ErrorMessage'], $deletePhoneRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deletePhoneRes['ErrorCode'], $deletePhoneRes['ErrorMessage'], $deletePhoneRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
