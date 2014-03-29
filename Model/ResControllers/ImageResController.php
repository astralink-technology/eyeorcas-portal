<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/imageDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');

class cp_ImageResController
{

    public function getImages(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

	    $ImageId = null;
        $Title = null;
        $Type = null;
        $Filename = null;
        $ImageUrl = null;
        $Status = null;
        $FileType = null;
        $DeviceId = null;
        $EntityId = null;
        $OwnerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['ImageId'])){ $ImageId = $_GET['ImageId']; };
        if (isset($_GET['Title'])){ $Title = $_GET['Title']; };
        if (isset($_GET['Type'])){ $Type = $_GET['Type']; };
        if (isset($_GET['Filename'])){ $Filename= $_GET['Filename']; };
        if (isset($_GET['ImageUrl'])){ $ImageUrl = $_GET['ImageUrl']; };
        if (isset($_GET['Status'])){ $Status = $_GET['Status']; };
        if (isset($_GET['FileType'])){ $FileType = $_GET['FileType']; };
        if (isset($_GET['DeviceId'])){ $OwnerId = $_GET['DeviceId']; };
        if (isset($_GET['EntityId'])){ $OwnerId = $_GET['EntityId']; };
        if (isset($_GET['OwnerId'])){ $OwnerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get image
        $imageDao = new cp_image_dao();
        $resImage = $imageDao->getImage(	
				$ImageId
				, $Title
				, $Type
				, $Filename
				, $ImageUrl
				, $Status
				, $FileType
				, $OwnerId
                , $pageSize
                , $skipSize
                , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($resImage)){
            $dataResponse->dataResponse($resImage['Data'], $resImage['ErrorCode'], $resImage['ErrorMessage'], $resImage['Error'], $resImage['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $resImage['ErrorCode'], $resImage['ErrorMessage'], $resImage['Error']);
        }
        return;
    }

    public function addImage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newImage = json_decode($jsonPost, true);

            $Title = null;
            $Type = null;
            $Filename = null;
            $ImageUrl = null;
            $Status = null;
            $Description = null;
            $FileType = null;
            $DeviceId = null;
            $EntityId = null;
            $FileSize = null;
            $OwnerId = null;
            $enterpriseId= null;


            if (isset($newImage['EnterpriseId'])){ $enterpriseId = $newImage['EnterpriseId']; };
            if (isset($newImage['Title'])){ $Title = $newImage['Title']; };
            if (isset($newImage['Type'])){ $Type = $newImage['Type']; };
            if (isset($newImage['FileName'])){ $Filename = $newImage['FileName']; };
            if (isset($newImage['ImageUrl'])){ $ImageUrl = $newImage['ImageUrl'] . $_FILES['uploaded_file']['name']; };
            if (isset($newImage['Status'])){ $Status = $newImage['Status']; };
            if (isset($newImage['Description'])){ $Description = $newImage['Description']; };
            if (isset($newImage['FileType'])){ $FileType = $newImage['FileType']; };
            if (isset($newImage['DeviceId'])){ $OwnerId = $newImage['DeviceId']; };
            if (isset($newImage['EntityId'])){ $OwnerId = $newImage['EntityId']; };
            if (isset($newImage['OwnerId'])){ $OwnerId = $newImage['OwnerId']; };
            if (isset($newImage['FileSize'])){ $FileSize = $newImage['FileSize']; };

            //insert a new image
            $imageDao = new cp_image_dao();
            $addImageRes = $imageDao->createImage(
                $Title
                , $Filename
                , $Type
                , $ImageUrl
                , $Status
                , $Description
                , $FileType
                , $OwnerId
                , $FileSize
                , $enterpriseId
            );
            if ($databaseHelper->hasDataNoError($addImageRes)){
                $dataResponse->dataResponse($addImageRes['Id'], $addImageRes['ErrorCode'], $addImageRes['ErrorMessage'], $addImageRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addImageRes['ErrorCode'], $addImageRes['ErrorMessage'], $addImageRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }

    }

    public function updateImage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateImage = json_decode($jsonPost, true);
	        $ImageId = null;
            $Title = null;
            $Type = null;
            $Filename = null;
            $ImageUrl = null;
            $Status = null;
            $Description = null;
            $FileType = null;
            $DeviceId = null;
            $EntityId = null;
            $OwnerId = null;
            $FileSize = null;
            $entepriseId = null;

            if (isset($updateImage['EnterpriseId'])){ $entepriseId = $updateImage['EnterpriseId']; };
            if (isset($updateImage['ImageId'])){ $ImageId = $updateImage['ImageId']; };
            if (isset($updateImage['Title'])){ $Title = $updateImage['Title']; };
            if (isset($updateImage['Type'])){ $Type = $updateImage['Type']; };
            if (isset($updateImage['Filename'])){ $Filename = $updateImage['Filename']; };
            if (isset($updateImage['ImageUrl'])){ $ImageUrl = $updateImage['ImageUrl']; };
            if (isset($updateImage['Status'])){ $Status = $updateImage['Status']; };
            if (isset($updateImage['Description'])){ $Description = $updateImage['Description']; };
            if (isset($updateImage['FileType'])){ $FileType = $updateImage['FileType']; };
            if (isset($updateImage['DeviceId'])){ $OwnerId = $updateImage['DeviceId']; };
            if (isset($updateImage['EntityId'])){ $OwnerId = $updateImage['EntityId']; };
            if (isset($updateImage['OwnerId'])){ $OwnerId = $updateImage['OwnerId']; };
            if (isset($updateImage['FileSize'])){ $FileSize = $updateImage['FileSize']; };

            //image Id and entity Id is required for editing the Image
            if ($ImageId != null && $DeviceId != null){
                //get the json formatted data
                $imageDb = new cp_image_dao();
                $updateImageRes = $imageDb->updateImage(
                    $ImageId
                    , $Title
                    , $Type
                    , $Filename
                    , $ImageUrl
                    , $Status
                    , $Description
                    , $FileType
                    , $OwnerId
                    , $FileSize
                    , $entepriseId
                );

                if ($databaseHelper->hasDataNoError($updateImageRes)){
                    $dataResponse->dataResponse($updateImageRes['Id'], $updateImageRes['ErrorCode'], $updateImageRes['ErrorMessage'], $updateImageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateImageRes['ErrorCode'], $updateImageRes['ErrorMessage'], $updateImageRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, 'Device and Image ID is required', true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeImage(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteImage = json_decode($jsonPost, true);

            $imageId = null;
            $enterpriseId = null;

            if (isset($deleteImage['EnterpriseId'])){ $enterpriseId = $deleteImage['EnterpriseId']; };
            if (isset($deleteImage['ImageId'])){ $imageId = $deleteImage['ImageId']; };

            //Image Id is required to delete the Image
            if ($imageId != null){
                //get the json formatted data
                $imageDb = new cp_image_dao();
                $deleteImageRes = $imageDb->deleteImage(
                    $imageId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteImageRes)){
                    $dataResponse->dataResponse($deleteImageRes['Id'], $deleteImageRes['ErrorCode'], $deleteImageRes['ErrorMessage'], $deleteImageRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteImageRes['ErrorCode'], $deleteImageRes['ErrorMessage'], $deleteImageRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

}
?>
