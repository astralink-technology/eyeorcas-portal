<?php
/*
 * Product Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ProductClass.php');

class cp_product_dao{
/*
 * Product CRUD
 */
    public function createProduct(
                $pName = null
                , $pDescription = null
                , $pStatus = null
                , $pType = null
                , $pCode = null
                , $pOwnerId = null
                , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $productId = $idgeneratorhelper->generateId();
	
	    $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_product (
            $1, $2, $3, $4, $5, $6, $7, $8, $9
            )"
            , array(
            $productId
            , $pName
	        , $pDescription
            , $pStatus
            , $pType
            , $pCode
            , $pCreateDate
            , null
            , $pOwnerId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $productId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
        
    }


    public function getProduct(
            $pProductId
	        , $pName = null
            , $pStatus = null
	        , $pType = null
            , $pCode = null
            , $pOwnerId = null
            , $pPageSize = null
            , $pSkipSize = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	    $res = pg_query_params($connectionString,
                "SELECT * FROM get_product(
                    $1, $2, $3, $4, $5, $6, $7, $8
                )"
                , array(
                    $pProductId
                    , $pName
                    , $pStatus
                    , $pType
                    , $pCode
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $productClass = new cp_Product();
                $productClass->productId = $row["product_id"];
                $productClass->name = $row["name"];
                $productClass->description = $row["description"];
                $productClass->status = $row["status"];
                $productClass->type = $row["type"];
                $productClass->code = $row["code"];
                $productClass->createDate = $row["create_date"];
                $productClass->lastUpdate = $row["last_update"];
                $productClass->ownerId = $row["owner_id"];
                $productClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $productClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	    $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function updateProduct(
            $pProductId
            , $pName = null
            , $pDescription = null
            , $pStatus = null
            , $pType = null
            , $pCode = null
	        , $pLastUpdate = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_product(
                    $1, $2, $3, $4, $5, $6, $7, $8
                )"
                , array(
                    $pProductId
                    , $pName
                    , $pDescription
                    , $pStatus
                    , $pType
                    , $pCode
                    , $pLastUpdate
                    , $pOwnerId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deleteProduct(
            $pProductId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_product(
                $1
            )"
            , array(
                $pProductId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
