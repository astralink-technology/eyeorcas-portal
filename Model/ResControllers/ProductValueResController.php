<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/productValueDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_ProductValueResController
{
    public function getProductValues(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $productValueId = null;
        $productValueName = null;
        $value = null;
        $value2 = null;
        $value3 = null;
        $valueUnit = null;
        $status = null;
        $type = null;
        $productId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['ProductValueId'])){ $productValueId = $_GET['ProductValueId']; };
        if (isset($_GET['ProductValueName'])){ $productValueName = $_GET['ProductValueName']; };
        if (isset($_GET['Value'])){ $value3 = $_GET['Value']; };
        if (isset($_GET['Value2'])){ $value2= $_GET['Value2']; };
        if (isset($_GET['Value3'])){ $value3 = $_GET['Value3']; };
        if (isset($_GET['ValueUnit'])){ $valueUnit = $_GET['ValueUnit']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['ProductId'])){ $productId = $_GET['ProductId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

            //get the json formatted data
            $productValueDb = new cp_product_value_dao();
            $productValueRes = $productValueDb->getProductValue(
                $productValueId 
                , $productValueName
                , $value
                , $value2
                , $value3
                , $valueUnit
                , $status
                , $type
                , $productId
                , $pageSize
                , $skipSize
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($productValueRes)){
                $dataResponse->dataResponse($productValueRes['Data'], $productValueRes['ErrorCode'], $productValueRes['ErrorMessage'], $productValueRes['Error'], $productValueRes['TotalRowsAvailable']);
            }else{
                $dataResponse->dataResponse(null, $productValueRes['ErrorCode'], $productValueRes['ErrorMessage'], $productValueRes['Error']);
            }
            return;
    }

    public function addProductValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newProductValue = json_decode($jsonPost, true);

            $productValueId = null;
            $productValueName = null;
            $value = null;
            $value2 = null;
            $value3 = null;
            $valueUnit = null;
            $status = null;
            $type = null;
            $productId = null;
            $enterpriseId = null;

            if (isset($newProductValue['EnterpriseId'])){ $enterpriseId = $newProductValue['EnterpriseId']; };
            if (isset($newProductValue['ProductValueId'])){ $message = $newProductValue['ProductValueId']; };
            if (isset($newProductValue['ProductValueName'])){ $title = $newProductValue['ProductValueName']; };
            if (isset($newProductValue['Value'])){ $type = $newProductValue['Value']; };
            if (isset($newProductValue['Value2'])){ $logUrl = $newProductValue['Value2']; };
            if (isset($newProductValue['Value3'])){ $status = $newProductValue['Value3']; };
            if (isset($newProductValue['ValueUnit'])){ $entityId = $newProductValue['ValueUnit']; };
            if (isset($newProductValue['Status'])){ $deviceId = $newProductValue['Status']; };
            if (isset($newProductValue['Type'])){ $deviceId = $newProductValue['Type']; };
            if (isset($newProductValue['ProductId'])){ $deviceId = $newProductValue['ProductId']; };

            //get the json formatted data
            $productValueDb = new cp_product_value_dao();
            $addProductValueRes = $productValueDb->createProductValue(
                $productValueId 
                , $productValueName
                , $value
                , $value2
                , $value3
                , $valueUnit
                , $status
                , $type
                , $productId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addProductValueRes)){
                $dataResponse->dataResponse($addProductValueRes['Id'], $addProductValueRes['ErrorCode'], $addProductValueRes['ErrorMessage'], $addProductValueRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addProductValueRes['ErrorCode'], $addProductValueRes['ErrorMessage'], $addProductValueRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateProductValue(){

        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateProductValue = json_decode($jsonPost, true);
            
            $productValueId = null;
            $productValueName = null;
            $value = null;
            $value2 = null;
            $value3 = null;
            $valueUnit = null;
            $status = null;
            $type = null;
            $lastUpdate = null;
            $productId = null;
            $enterpriseId = null;

            if (isset($updateProductValue['EnterpriseId'])){ $enterpriseId = $updateProductValue['EnterpriseId']; };
            if (isset($updateProductValue['ProductValueId'])){ $message = $updateProductValue['ProductValueId']; };
            if (isset($updateProductValue['ProductValueName'])){ $title = $updateProductValue['ProductValueName']; };
            if (isset($updateProductValue['Value'])){ $type = $updateProductValue['Value']; };
            if (isset($updateProductValue['Value2'])){ $logUrl = $updateProductValue['Value2']; };
            if (isset($updateProductValue['Value3'])){ $status = $updateProductValue['Value3']; };
            if (isset($updateProductValue['ValueUnit'])){ $entityId = $updateProductValue['ValueUnit']; };
            if (isset($updateProductValue['Status'])){ $deviceId = $updateProductValue['Status']; };
            if (isset($updateProductValue['Type'])){ $deviceId = $updateProductValue['Type']; };
            if (isset($updateProductValue['LastUpdate'])){ $deviceId = $updateProductValue['LastUpdate']; };
            if (isset($updateProductValue['ProductId'])){ $deviceId = $updateProductValue['ProductId']; };

            //get the json formatted data
            $productValueDb = new cp_product_value_dao();
            $updateProductValueRes = $productValueDb->updateProductValue(
                $productValueId
                , $productValueName
                , $value
                , $value2
                , $value3
                , $valueUnit
                , $status
                , $type
                , $lastUpdate
                , $productId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($updateProductValueRes)){
                $dataResponse->dataResponse($updateProductValueRes['Id'], $updateProductValueRes['ErrorCode'], $updateProductValueRes['ErrorMessage'], $updateProductValueRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $updateProductValueRes['ErrorCode'], $updateProductValueRes['ErrorMessage'], $updateProductValueRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeProductValue(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteProductValue = json_decode($jsonPost, true);

            $enterpriseId = null;
            $productValueId = null;

            if (isset($deleteProductValue['EnterpriseId'])){ $enterpriseId = $deleteProductValue['EnterpriseId']; };
            if (isset($deleteProductValue['ProductValueId'])){ $productValueId = $deleteProductValue['ProductValueId']; };

            //product value id is required to delete the log
            if ($productValueId != null){
                //get the json formatted data
                $productValueDb = new cp_product_value_dao();
                $deleteProductValueRes = $productValueDb->deleteProductValue(
                    $productValueId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteProductValueRes)){
                    $dataResponse->dataResponse($deleteProductValueRes['Id'], $deleteProductValueRes['ErrorCode'], $deleteProductValueRes['ErrorMessage'], $deleteProductValueRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteProductValueRes['ErrorCode'], $deleteProductValueRes['ErrorMessage'], $deleteProductValueRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
