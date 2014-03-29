<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/productRegistrationDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_ProductRegistrationResController
{
    public function getProductEntityRegistrationDetails(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $productRegistrationId = null;
        $type = null;
        $status = null;
        $productId = null;
        $entityId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['ProductRegistrationId'])){ $productRegistrationId= $_GET['ProductRegistrationId']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['ProductId'])){ $productId = $_GET['ProductId']; };
        if (isset($_GET['EntityId'])){ $entityId = $_GET['EntityId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data

        $productRegistrationDb = new cp_product_registration_dao();
        $getProductRegistrationRes = $productRegistrationDb->getProductEntityRegistrationDetails(
            $productRegistrationId
            , $status
            , $type
            , $productId
            , $entityId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getProductRegistrationRes )){
            $dataResponse->dataResponse($getProductRegistrationRes ['Data'], $getProductRegistrationRes ['ErrorCode'], $getProductRegistrationRes ['ErrorMessage'], $getProductRegistrationRes ['Error'], $getProductRegistrationRes ['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getProductRegistrationRes ['ErrorCode'], $getProductRegistrationRes ['ErrorMessage'], $getProductRegistrationRes ['Error']);
        }
        return;

    }

    public function getProductRegistrations(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $productRegistrationId = null;
        $status = null;
        $type = null;
        $productId = null;
        $entityId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['ProductRegistrationId'])){ $productRegistrationId= $_GET['ProductRegistrationId']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['ProductId'])){ $productId = $_GET['ProductId']; };
        if (isset($_GET['EntityId'])){ $entityId = $_GET['EntityId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $productRegistrationDb = new cp_product_registration_dao();
        $getProductRegistrationRes = $productRegistrationDb->getProductRegistration(
            $productRegistrationId
            , $status
            , $type
            , $productId
            , $entityId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );
        if ($databaseHelper->hasDataNoError($getProductRegistrationRes )){
            $dataResponse->dataResponse($getProductRegistrationRes ['Data'], $getProductRegistrationRes ['ErrorCode'], $getProductRegistrationRes ['ErrorMessage'], $getProductRegistrationRes ['Error'], $getProductRegistrationRes ['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $getProductRegistrationRes ['ErrorCode'], $getProductRegistrationRes ['ErrorMessage'], $getProductRegistrationRes ['Error']);
        }
        return;
    }

    public function addProductRegistration(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newProductRegistration = json_decode($jsonPost, true);

            $status = null;
            $type = null;
            $productId = null;
            $entityId = null;
            $enterpriseId = null;

            if (isset($newProductRegistration['EnterpriseId'])){ $enterpriseId = $newProductRegistration['EnterpriseId']; };
            if (isset($newProductRegistration['Status'])){ $status = $newProductRegistration['Status']; };
            if (isset($newProductRegistration['Type'])){ $type = $newProductRegistration['Type']; };
            if (isset($newProductRegistration['ProductId'])){ $productId = $newProductRegistration['ProductId']; };
            if (isset($newProductRegistration['EntityId'])){ $entityId = $newProductRegistration['EntityId']; };

            //get the json formatted data
            $productRegistrationDb = new cp_product_registration_dao();
            $addProductRegistrationRes = $productRegistrationDb->createProductRegistration(
                $status
                , $type
                , $productId
                , $entityId
                , $enterpriseId
            );
            if ($databaseHelper->hasDataNoError($addProductRegistrationRes)){
                $dataResponse->dataResponse($addProductRegistrationRes['Id'], $addProductRegistrationRes['ErrorCode'], $addProductRegistrationRes['ErrorMessage'], $addProductRegistrationRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addProductRegistrationRes['ErrorCode'], $addProductRegistrationRes['ErrorMessage'], $addProductRegistrationRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateProductRegistration(){

        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateProductRegistration = json_decode($jsonPost, true);

            $productRegistrationId = null;
	        $status = null;
	        $type = null;
	        $lastUpdate = null;
            $productId = null;
	        $entityId = null;
	        $enterpriseId = null;

            if (isset($updateProductRegistration['EnterpriseId'])){ $enterpriseId = $updateProductRegistration['EnterpriseId']; };
            if (isset($updateProductRegistration['ProductRegistrationId'])){ $productRegistrationId = $updateProductRegistration['ProductRegistrationId']; };
            if (isset($updateProductRegistration['Status'])){ $status = $updateProductRegistration['Status']; };
            if (isset($updateProductRegistration['Type'])){ $type = $updateProductRegistration['Type']; };
            if (isset($updateProductRegistration['LastUpdate'])){ $lastUpdate = $updateProductRegistration['LastUpdate']; };
            if (isset($updateProductRegistration['ProductId'])){ $productId = $updateProductRegistration['ProductId']; };
            if (isset($updateProductRegistration['EntityId'])){ $entityId = $updateProductRegistration['EntityId']; };

            //get the json formatted data
            $productRegistrationDb = new cp_product_registration_dao();
            $updateProductRegistrationRes = $productRegistrationDb->updateProductRegistration(
                $productRegistrationId
                , $status
                , $type
                , $lastUpdate
                , $productId
                , $entityId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($updateProductRegistrationRes)){
                $dataResponse->dataResponse($updateProductRegistrationRes['Id'], $updateProductRegistrationRes['ErrorCode'], $updateProductRegistrationRes['ErrorMessage'], $updateProductRegistrationRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $updateProductRegistrationRes['ErrorCode'], $updateProductRegistrationRes['ErrorMessage'], $updateProductRegistrationRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeProductRegistration(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){

            $jsonPost = $_POST['json'];
            $deleteProductRegistration = json_decode($jsonPost, true);

            $enterpriseId = null;
            $productRegistrationId = null;

            if (isset($deleteProductRegistration['EnterpriseId'])){ $enterpriseId = $deleteProductRegistration['EnterpriseId']; };
            if (isset($deleteProductRegistration['ProductRegistrationId'])){ $productRegistrationId = $deleteProductRegistration['ProductRegistrationId']; };


            //product value id is required to delete the log
            if ($productRegistrationId != null){
                //get the json formatted data
                $productRegistrationDb = new cp_product_registration_dao();
                $deleteProductRegistrationRes = $productRegistrationDb->deleteProductRegistration(
                    $productRegistrationId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($deleteProductRegistrationRes)){
                    $dataResponse->dataResponse($deleteProductRegistrationRes['Id'], $deleteProductRegistrationRes['ErrorCode'], $deleteProductRegistrationRes['ErrorMessage'], $deleteProductRegistrationRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteProductRegistrationRes['ErrorCode'], $deleteProductRegistrationRes['ErrorMessage'], $deleteProductRegistrationRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>