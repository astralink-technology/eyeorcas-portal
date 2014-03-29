<?php
/*
 * Product Registration Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ProductRegistrationClass.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ProductEntityRegistrationDetailsClass.php');


class cp_product_registration_dao{
/*
 * Product Registration CRUD
 */
    public function createProductRegistration(
        $pStatus = null
        , $pType = null
        , $pProductId = null
		, $pOwnerId = null
        , $pEnterpriseId = null
        ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $pProductRegistrationId = $idgeneratorhelper->generateId();

	    $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_product_registration(
              $1, $2, $3, $4, $5, $6, $7
            )"
            , array(
                $pProductRegistrationId
                , $pStatus
                , $pType
                , $pCreateDate
                , null
                , $pProductId
                , $pOwnerId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductRegistrationId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function getProductRegistration(
            $pProductRegistrationId
	        , $pStatus = null
	        , $pType = null
            , $pProductId = null
	        , $pOwnerId = null
	        , $pPageSize = null
	        , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	    $res = pg_query_params($connectionString,
                "SELECT * FROM get_product_registration(
                    $1, $2, $3, $4, $5, $6, $7
                )"
                , array(
                    $pProductRegistrationId
                    , $pStatus
                    , $pType
                    , $pProductId
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	    $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $productRegistrationClass = new cp_Product_Registration();
            $productRegistrationClass->productRegistrationId = $row["product_registration_id"];
            $productRegistrationClass->status = $row["status"];
            $productRegistrationClass->type = $row["type"];
            $productRegistrationClass->createDate = $row["create_date"];
            $productRegistrationClass->lastUpdate= $row["last_update"];
            $productRegistrationClass->productId = $row["product_id"];
            $productRegistrationClass->ownerId = $row["owner_id"];
            $productRegistrationClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $productRegistrationClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	    $sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }


    public function getProductEntityRegistrationDetails(
        $pProductRegistrationId
        , $pStatus = null
        , $pType = null
        , $pProductId = null
        , $pOwnerId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_entity_product_registration_details(
                $1, $2, $3, $4, $5, $6, $7
            )"
            , array(
                $pProductRegistrationId
                , $pStatus
                , $pType
                , $pProductId
                , $pOwnerId
                , $pPageSize
                , $pSkipSize
            ));
        $data = array();
        $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $productEntityRegistrationDetailsClass = new cp_Product_Entity_Registration_Details();
            $productEntityRegistrationDetailsClass->productRegistrationId = $row["product_registration_id"];
            $productEntityRegistrationDetailsClass->status = $row["status"];
            $productEntityRegistrationDetailsClass->type = $row["type"];
            $productEntityRegistrationDetailsClass->createDate = $row["create_date"];
            $productEntityRegistrationDetailsClass->lastUpdate= $row["last_update"];
            $productEntityRegistrationDetailsClass->productId = $row["product_id"];
            $productEntityRegistrationDetailsClass->ownerId = $row["owner_id"];
            $productEntityRegistrationDetailsClass->entityName = $row["entity_name"];
            $productEntityRegistrationDetailsClass->productName = $row["product_name"];
            $productEntityRegistrationDetailsClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $productEntityRegistrationDetailsClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
        $sqlconnecthelper->dbDisconnect();
        return $retData;

    }

    public function updateProductRegistration(
            $pProductRegistrationId
	        , $pStatus = null
	        , $pType = null
	        , $pLastUpdate = null
            , $pProductId = null
	        , $pOwnerId = null
            , $pEnterpriseId = null
        ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_product_registration(
                    $1, $2, $3, $4, $5, $6
                )"
                , array(
                    $pProductRegistrationId
                    , $pStatus
                    , $pType
                    , $pLastUpdate
                    , $pProductId
                    , $pOwnerId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductRegistrationId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteProductRegistration(
	    $pProductRegistrationId
        , $pEnterpriseId = null
	){

        $sqlconnecthelper = new cp_sqlConnection_helper();
            $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString,
            "SELECT * FROM delete_product_registration(
                $1
            )"
            , array(
                $pProductRegistrationId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductRegistrationId);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
