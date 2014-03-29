<?php
/*
 * Image Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ImageClass.php');


class cp_image_dao{
/*
 * Product Registration CRUD
 */
    public function createImage(
            $pTitle = null
            , $pFilename = null
            , $pType = null
            , $pImageUrl = null
            , $pStatus = null
            , $pDescription = null
            , $pFileType = null
            , $pOwnerId = null
            , $pFileSize = null
            , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $imageId = $idgeneratorhelper->generateId();

	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_image (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11
            )"
            , array(
            $imageId
            , $pTitle
	        , $pType
            , $pFilename
            , $pImageUrl
	        , $pStatus
            , $pCreateDate
            , $pDescription
            , $pFileType
            , $pOwnerId
            , $pFileSize
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $imageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;

    }


    public function getImage(
            $pImageId
            , $pTitle = null
            , $pType = null
            , $pFilename = null
            , $pImageUrl = null
            , $pStatus = null
            , $pFileType = null
            , $pOwnerId = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	$res = pg_query_params($connectionString,
                "SELECT * FROM get_image(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
                )"
                , array(
                    $pImageId
                    , $pTitle
                    , $pType
                    , $pFilename
                    , $pImageUrl
                    , $pStatus
                    , $pFileType
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $imageClass = new cp_Image();
                $imageClass->imageId = $row["image_id"];
                $imageClass->title = $row["title"];
                $imageClass->filename = $row["file_name"];
                $imageClass->type = $row["type"];
                $imageClass->imageURL = $row["img_url"];
                $imageClass->status = $row["status"];
                $imageClass->description = $row["description"];
                $imageClass->fileType = $row["file_type"];
                $imageClass->createDate = $row["create_date"];
        		$imageClass->ownerId = $row["owner_id"];
        		$imageClass->fileSize = $row["file_size"];
        		$imageClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $imageClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateImage(
            $pImageId
            , $pTitle = null
            , $pType = null
	        , $pFilename = null
            , $pImageUrl = null
            , $pStatus = null
            , $pDescription = null
            , $pFileType = null
	        , $pOwnerId = null
	        , $pFileSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_image(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
                )"
                , array(
                    $pImageId
                    , $pTitle
                    , $pType
                    , $pFilename
                    , $pImageUrl
                    , $pStatus
                    , $pDescription
                    , $pFileType
                    , $pOwnerId
                    , $pFileSize
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pImageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteImage(
            $pImageId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_image(
                $1
            )"
            , array(
                $pImageId
            ));  
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pImageId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
