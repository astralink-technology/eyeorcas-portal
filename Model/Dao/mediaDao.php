<?php
/*
 * Media Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/MediaClass.php');


class cp_media_dao{
/*
 * Product Registration CRUD
 */
    public function createMedia(
            $pTitle = null
            , $pFilename = null
            , $pType = null
            , $pMediaUrl = null
            , $pStatus = null
            , $pDescription = null
            , $pFileType = null
            , $pImgUrl = null
            , $pImgUrl2 = null
            , $pImgUrl3 = null
            , $pImgUrl4 = null
            , $pOwnerId = null
            , $pFileSize = null
            , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $mediaId = $idgeneratorhelper->generateId();

	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_media (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15
            )"
            , array(
            $mediaId
            , $pTitle
	        , $pType
            , $pFilename
            , $pMediaUrl
	        , $pStatus
            , $pCreateDate
            , $pDescription
            , $pFileType
            , $pImgUrl
            , $pImgUrl2
            , $pImgUrl3
            , $pImgUrl4
            , $pOwnerId
            , $pFileSize
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $mediaId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;

    }


    public function getMedia(
            $pMediaId
            , $pTitle = null
            , $pType = null
            , $pFilename = null
            , $pMediaUrl = null
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
                "SELECT * FROM get_media(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
                )"
                , array(
                    $pMediaId
                    , $pTitle
                    , $pType
                    , $pFilename
                    , $pMediaUrl
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
                $mediaClass = new cp_Media();
                $mediaClass->mediaId = $row["media_id"];
                $mediaClass->title = $row["title"];
                $mediaClass->filename = $row["file_name"];
                $mediaClass->type = $row["type"];
                $mediaClass->mediaURL = $row["media_url"];
                $mediaClass->status = $row["status"];
                $mediaClass->description = $row["description"];
                $mediaClass->fileType = $row["file_type"];
                $mediaClass->imgUrl = $row["image_url"];
                $mediaClass->imgUrl2 = $row["image_url2"];
                $mediaClass->imgUrl3 = $row["image_url3"];
                $mediaClass->imgUrl4 = $row["image_url4"];
                $mediaClass->createDate = $row["create_date"];
        		$mediaClass->ownerId = $row["owner_id"];
        		$mediaClass->fileSize = $row["file_size"];
        		$mediaClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $mediaClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	$sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateMedia(
            $pMediaId
            , $pTitle = null
            , $pType = null
	        , $pFilename = null
            , $pMediaUrl = null
            , $pStatus = null
            , $pDescription = null
            , $pFileType = null
            , $pImgUrl = null
            , $pImgUrl2 = null
            , $pImgUrl3 = null
            , $pImgUrl4 = null
	        , $pOwnerId = null
	        , $pFileSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_media(
                    $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14
                )"
                , array(
                    $pMediaId
                    , $pTitle
                    , $pType
                    , $pFilename
                    , $pMediaUrl
                    , $pStatus
                    , $pDescription
                    , $pFileType
                    , $pImgUrl
                    , $pImgUrl2
                    , $pImgUrl3
                    , $pImgUrl4
                    , $pOwnerId
                    , $pFileSize
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pMediaId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteMedia(
            $pMediaId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_media(
                $1
            )"
            , array(
                $pMediaId
            ));  
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pMediaId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
