<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/mediaDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');

class cp_MediaResController
{

    public function getMedia(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

	    $MediaId = null;
        $Title = null;
        $Type = null;
        $Filename = null;
        $MediaUrl = null;
        $Status = null;
        $FileType = null;
        $OwnerId = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['MediaId'])){ $MediaId = $_GET['MediaId']; };
        if (isset($_GET['Title'])){ $Title = $_GET['Title']; };
        if (isset($_GET['Type'])){ $Type = $_GET['Type']; };
        if (isset($_GET['Filename'])){ $Filename= $_GET['Filename']; };
        if (isset($_GET['MediaUrl'])){ $MediaUrl = $_GET['MediaUrl']; };
        if (isset($_GET['Status'])){ $Status = $_GET['Status']; };
        if (isset($_GET['FileType'])){ $FileType = $_GET['FileType']; };
        if (isset($_GET['OwnerId'])){ $OwnerId = $_GET['OwnerId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get media
        $mediaDao = new cp_media_dao();
        $resMedia = $mediaDao->getMedia(	
				$MediaId
				, $Title
				, $Type
				, $Filename
				, $MediaUrl
				, $Status
				, $FileType
				, $OwnerId
                , $pageSize
                , $skipSize
                , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($resMedia)){
            $dataResponse->dataResponse($resMedia['Data'], $resMedia['ErrorCode'], $resMedia['ErrorMessage'], $resMedia['Error'], $resMedia['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, $resMedia['ErrorCode'], $resMedia['ErrorMessage'], $resMedia['Error']);
        }
        return;
    }

    public function addMedia(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newMedia = json_decode($jsonPost, true);

            $Title = null;
            $Type = null;
            $Filename = null;
            $MediaUrl = null;
            $Status = null;
            $Description = null;
            $FileType = null;
            $ImgUrl = null;
            $ImgUrl2 = null;
            $ImgUrl3 = null;
            $ImgUrl4 = null;
            $OwnerId = null;
            $FileSize = null;
            $enterpriseId = null;


            if (isset($newMedia['EnterpriseId'])){ $enterpriseId = $newMedia['EnterpriseId']; };
            if (isset($newMedia['Title'])){ $Title = $newMedia['Title']; };
            if (isset($newMedia['Type'])){ $Type = $newMedia['Type']; };
            if (isset($newMedia['FileName'])){ $Filename = $newMedia['FileName']; };
            if (isset($newMedia['MediaUrl'])){ $MediaUrl = $newMedia['MediaUrl'] . $_FILES['uploaded_file']['name']; };
            if (isset($newMedia['Status'])){ $Status = $newMedia['Status']; };
            if (isset($newMedia['Description'])){ $Description = $newMedia['Description']; };
            if (isset($newMedia['FileType'])){ $FileType = $newMedia['FileType']; };
            if (isset($newMedia['ImgUrl'])){ $ImgUrl = $newMedia['ImgUrl']; };
            if (isset($newMedia['ImgUrl2'])){ $ImgUrl2 = $newMedia['ImgUrl2']; };
            if (isset($newMedia['ImgUrl3'])){ $ImgUrl3 = $newMedia['ImgUrl3']; };
            if (isset($newMedia['ImgUrl4'])){ $ImgUrl4 = $newMedia['ImgUrl4']; };
            if (isset($newMedia['OwnerId'])){ $OwnerId = $newMedia['OwnerId']; };
            if (isset($newMedia['FileSize'])){ $FileSize = $newMedia['FileSize']; };

            //insert a new media
            $mediaDao = new cp_media_dao();
            $addMediaRes = $mediaDao->createMedia(
                $Title
                , $Filename
                , $Type
                , $MediaUrl
                , $Status
                , $Description
                , $FileType
                , $ImgUrl
                , $ImgUrl2
                , $ImgUrl3
                , $ImgUrl4
                , $OwnerId
                , $FileSize
                , $enterpriseId
            );
            if ($databaseHelper->hasDataNoError($addMediaRes)){
                $dataResponse->dataResponse($addMediaRes['Id'], $addMediaRes['ErrorCode'], $addMediaRes['ErrorMessage'], $addMediaRes['Error']);
            }else{
                $dataResponse->dataResponse(null, $addMediaRes['ErrorCode'], $addMediaRes['ErrorMessage'], $addMediaRes['Error']);
            }
            return;
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }

    }

    public function updateMedia(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $UTChelper = new cp_UTCconvertor_helper();
        $lastUpdate = $UTChelper->getCurrentDateTime();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateMedia = json_decode($jsonPost, true);
	        $MediaId = null;
            $Title = null;
            $Type = null;
            $Filename = null;
            $MediaUrl = null;
            $Status = null;
            $Description = null;
            $FileType = null;
            $ImgUrl = null;
            $ImgUrl2 = null;
            $ImgUrl3 = null;
            $ImgUrl4 = null;
            $OwnerId = null;
            $FileSize = null;
            $enterpriseId = null;

            if (isset($updateMedia['EnterpriseId'])){ $enterpriseId = $updateMedia['EnterpriseId']; };
            if (isset($updateMedia['MediaId'])){ $MediaId = $updateMedia['MediaId']; };
            if (isset($updateMedia['Title'])){ $Title = $updateMedia['Title']; };
            if (isset($updateMedia['Type'])){ $Type = $updateMedia['Type']; };
            if (isset($updateMedia['Filename'])){ $Filename = $updateMedia['Filename']; };
            if (isset($updateMedia['MediaUrl'])){ $MediaUrl = $updateMedia['MediaUrl']; };
            if (isset($updateMedia['Status'])){ $Status = $updateMedia['Status']; };
            if (isset($updateMedia['Description'])){ $Description = $updateMedia['Description']; };
            if (isset($updateMedia['FileType'])){ $FileType = $updateMedia['FileType']; };
            if (isset($updateMedia['ImgUrl'])){ $ImgUrl = $updateMedia['ImgUrl']; };
            if (isset($updateMedia['ImgUrl2'])){ $ImgUrl2 = $updateMedia['ImgUrl2']; };
            if (isset($updateMedia['ImgUrl3'])){ $ImgUrl3 = $updateMedia['ImgUrl3']; };
            if (isset($updateMedia['ImgUrl4'])){ $ImgUrl4 = $updateMedia['ImgUrl4']; };
            if (isset($updateMedia['OwnerId'])){ $OwnerId = $updateMedia['OwnerId']; };
            if (isset($updateMedia['FileSize'])){ $FileSize = $updateMedia['FileSize']; };

            //media Id and entity Id is required for editing the Media
            if ($MediaId != null && OwnerId != null){
                //get the json formatted data
                $mediaDb = new cp_media_dao();
                $updateMediaRes = $mediaDb->updateMedia(
                    $MediaId
                    , $Title
                    , $Type
                    , $Filename
                    , $MediaUrl
                    , $Status
                    , $Description
                    , $FileType
                    , $ImgUrl
                    , $ImgUrl2
                    , $ImgUrl3
                    , $ImgUrl4
                    , $OwnerId
                    , $FileSize
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($updateMediaRes)){
                    $dataResponse->dataResponse($updateMediaRes['Id'], $updateMediaRes['ErrorCode'], $updateMediaRes['ErrorMessage'], $updateMediaRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $updateMediaRes['ErrorCode'], $updateMediaRes['ErrorMessage'], $updateMediaRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, 'Device and Media ID is required', true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }

    public function removeMedia(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $deleteMedia = json_decode($jsonPost, true);

            $mediaId = null;
            $enterpriseId = null;

            if (isset($deleteMedia['EnterpriseId'])){ $enterpriseId = $deleteMedia['EnterpriseId']; };
            if (isset($deleteMedia['MediaId'])){ $mediaId = $deleteMedia['MediaId']; };

            //Media Id is required to delete the Media
            if ($mediaId != null){
                //get the json formatted data
                $mediaDb = new cp_media_dao();
                $deleteMediaRes = $mediaDb->deleteMedia(
                    $mediaId
                    , $enterpriseId
                );
                if ($databaseHelper->hasDataNoError($deleteMediaRes)){
                    $dataResponse->dataResponse($deleteMediaRes['Id'], $deleteMediaRes['ErrorCode'], $deleteMediaRes['ErrorMessage'], $deleteMediaRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $deleteMediaRes['ErrorCode'], $deleteMediaRes['ErrorMessage'], $deleteMediaRes['Error']);
                }
            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
 

    public function addMediaFromHXS(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $newMedia = json_decode($jsonPost, true);

            $Title = null;
            $Type = null;
            $Filename = null;
            $MediaUrl = null;
            $Status = null;
            $Description = null;
            $FileType = null;
            $ImgUrl = null;
            $ImgUrl2 = null;
            $ImgUrl3 = null;
            $ImgUrl4 = null;
            $DeviceId = null;
            $OwnerId = null;
            $DeviceCode = null;
            $enterpriseId = null;

            if (isset($newMedia['Title'])){ $Title = $newMedia['Title']; };
            if (isset($newMedia['Type'])){ $Type = $newMedia['Type']; };
            if (isset($_FILES['uploaded_file']['name'])){ $Filename = $_FILES['uploaded_file']['name']; };
            if (isset($newMedia['MediaUrl'])){ $MediaUrl = $newMedia['MediaUrl']; };
            if (isset($newMedia['Status'])){ $Status = $newMedia['Status']; };
            if (isset($newMedia['Description'])){ $Description = $newMedia['Description']; };
            if (isset($newMedia['ImgUrl'])){ $ImgUrl = $newMedia['ImgUrl']; };
            if (isset($newMedia['ImgUrl2'])){ $ImgUrl2 = $newMedia['ImgUrl2']; };
            if (isset($newMedia['ImgUrl3'])){ $ImgUrl3 = $newMedia['ImgUrl3']; };
            if (isset($newMedia['ImgUrl4'])){ $ImgUrl4 = $newMedia['ImgUrl4']; };
            if (isset($newMedia['DeviceCode'])){ $DeviceCode = $newMedia['DeviceCode']; };
            if (isset($newMedia['EnterpriseId'])){ $enterpriseId = $newMedia['EnterpriseId']; };

            $path_parts = pathinfo($_FILES["uploaded_file"]["name"]);
            $FileType = $path_parts['extension'];
	        $FileSize = $_FILES['uploaded_file']['size'];

            $tempUrl = '/var/www/tmp_dir/' . $DeviceCode . '/';
            if(!file_exists($tempUrl))
            {
                mkdir($tempUrl);
            }
            $MediaPath = $tempUrl . basename( $_FILES['uploaded_file']['name']);
            if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $MediaPath)) {
                //Successfull uploaded
            } else{
                $dataResponse->dataResponse(null, -1, "Failed to move file", true);
                return;
            }


            //get the json formatted data
            $deviceRelationshipDb = new cp_device_relationship_dao();
            $entityDeviceRelationshipRes = $deviceRelationshipDb->getEntityDeviceRelationshipValue(
            	null
            	, null
            	, null
            	, $DeviceCode
            	, null
            	, null
            	, null
            	, null
            	, null
            	, null
            	, null
            	, null
            	, null
            	, null
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($entityDeviceRelationshipRes)){
                if ($entityDeviceRelationshipRes["TotalRowsAvailable"] > 0){
                    for($r = 0; $r < $entityDeviceRelationshipRes['TotalRowsAvailable']; $r++){
                        $deviceRelationshipId = $entityDeviceRelationshipRes["Data"][$r]->deviceRelationshipId;
			            $ownerId = $entityDeviceRelationshipRes["Data"][$r]->ownerId;
                        $CopyPath = '/var/www/gallery/' . $ownerId . '/';
                        if(!file_exists($CopyPath))
                        {
                            mkdir($CopyPath);
                        }
                        if(copy($MediaPath, $CopyPath.$Filename)) {
                            //Successfull uploaded
                        } else{
                            $dataResponse->dataResponse(null, -1, "Failed to Upload", true);
                            return;
                        }

                        if ($deviceRelationshipId != null){
                            $MediaUrl = $MediaUrl . $ownerId . "/" . $Filename;
                            //insert a new media
                            $mediaDao = new cp_media_dao();
                            $addMediaRes = $mediaDao->createMedia(
                                $Title
                                , $Filename
                                , $Type
                                , $MediaUrl
                                , $Status
                                , $Description
                                , $FileType
                                , $ImgUrl
                                , $ImgUrl2
                                , $ImgUrl3
                                , $ImgUrl4
                                , $deviceRelationshipId
                                , $FileSize
                                , $enterpriseId
                            );
                            if ($databaseHelper->hasDataNoError($addMediaRes)){
                                $dataResponse->dataResponse($addMediaRes['Id'], $addMediaRes['ErrorCode'], $addMediaRes['ErrorMessage'], $addMediaRes['Error']);
                            }else{
                                $dataResponse->dataResponse(null, $addMediaRes['ErrorCode'], $addMediaRes['ErrorMessage'], $addMediaRes['Error']);
                            }
                            return;
                        }else{
                            $dataResponse->dataResponse(null, -1, "Failed to add Media", true);
                            return;
                        }
                    }
                }else{
                    $dataResponse->dataResponse(null, -1, "No User Found", true);
                    return;
                }
            }else{

            }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }

    }

}
?>
