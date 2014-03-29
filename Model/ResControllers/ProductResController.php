<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/productDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_ProductResController
{
    public function getProducts(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $productId = null;
        $name = null;
        $status = null;
        $type = null;
        $code = null;
        $ownerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['ProductId'])){ $productId = $_GET['ProductId']; };
        if (isset($_GET['Name'])){ $name = $_GET['Name']; };
        if (isset($_GET['Status'])){ $status = $_GET['Status']; };
        if (isset($_GET['Type'])){ $type = $_GET['Type']; };
        if (isset($_GET['Code'])){ $code = $_GET['Code']; };
        if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $productDb = new cp_product_dao();
        $productRes = $productDb->getProduct(
            $productId
            , $name
            , $status
            , $type
            , $code
            , $ownerId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($productRes)){
            $dataResponse->dataResponse($productRes['Data'], $productRes['ErrorCode'], $productRes['ErrorMessage'], $productRes['Error'], $productRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $productRes['ErrorCode'], $productRes['ErrorMessage'], $productRes['Error']);
        }
        return;
    }

    public function addProduct(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newProduct = json_decode($jsonPost, true);

            $name = null;
            $description = null;
            $status = null;
            $type = null;
            $code = null;
            $ownerId = null;
            $enterpriseId = null;

            if (isset($newProduct['EnterpriseId'])){ $enterpriseId = $newProduct['EnterpriseId']; };
            if (isset($newProduct['Name'])){ $message = $newProduct['Name']; };
            if (isset($newProduct['Description'])){ $title = $newProduct['Description']; };
            if (isset($newProduct['Status'])){ $type = $newProduct['Status']; };
            if (isset($newProduct['Type'])){ $status = $newProduct['Type']; };
            if (isset($newProduct['Code'])){ $status = $newProduct['Code']; };
            if (isset($newProduct['OwnerId'])){ $ownerId = $newProduct['OwnerId']; };

            //get the json formatted data
            $productDb = new cp_product_dao();
            $addProductRes = $productDb->createProduct(
                $name
                , $description
                , $status
                , $type
                , $code
                , $ownerId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($addProductRes)){
                $dataResponse->dataResponse($addProductRes['Id'], $addProductRes['ErrorCode'], $addProductRes['ErrorMessage'], $addProductRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addProductRes['ErrorCode'], $addProductRes['ErrorMessage'], $addProductRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function updateProduct(){

        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateProduct = json_decode($jsonPost, true);

            $productId = null;
            $name = null;
            $description = null;
            $status = null;
            $type = null;
            $code = null;
	        $lastUpdate = null;
	        $ownerId = null;
	        $enterpriseId= null;

            if (isset($updateProduct['EnterpriseId'])){ $message = $updateProduct['EnterpriseId']; };
            if (isset($updateProduct['ProductId'])){ $message = $updateProduct['ProductId']; };
            if (isset($updateProduct['Name'])){ $title = $updateProduct['Name']; };
            if (isset($updateProduct['Description'])){ $type = $updateProduct['Description']; };
            if (isset($updateProduct['Status'])){ $logUrl = $updateProduct['Status']; };
            if (isset($updateProduct['Type'])){ $status = $updateProduct['Type']; };
            if (isset($updateProduct['Code'])){ $code = $updateProduct['Code']; };
            if (isset($updateProduct['LastUpdate'])){ $lastUpdate = $updateProduct['LastUpdate']; };
            if (isset($updateProduct['OwnerId'])){ $ownerId = $updateProduct['OwnerId']; };

            //get the json formatted data
            $productDb = new cp_product_dao();
            $updateProductRes = $productDb->updateProduct(
                $productId
                , $name
                , $description
                , $status
                , $type
                , $code
                , $lastUpdate
                , $ownerId
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($updateProductRes)){
                $dataResponse->dataResponse($updateProductRes['Id'], $updateProductRes['ErrorCode'], $updateProductRes['ErrorMessage'], $updateProductRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $updateProductRes['ErrorCode'], $updateProductRes['ErrorMessage'], $updateProductRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeProduct(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteProduct = json_decode($jsonPost, true);

            $enterpriseId = null;
            $productId = null;

            if (isset($deleteProduct['EnterpriseId'])){ $enterpriseId = $deleteProduct['EnterpriseId']; };
            if (isset($deleteProduct['ProductId'])){ $productId  = $deleteProduct['ProductId']; };

            //product value id is required to delete the log
            if ($productId != null){
                //get the json formatted data
                $productDb = new cp_product_dao();
                $deleteProductRes = $productDb->deleteProduct(
                    $productId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteProductRes)){
                    $dataResponse->dataResponse($deleteProductRes['Id'], $deleteProductRes['ErrorCode'], $deleteProductRes['ErrorMessage'], $deleteProductRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteProductRes['ErrorCode'], $deleteProductRes['ErrorMessage'], $deleteProductRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
