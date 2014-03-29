<?php
/*
 * Product Registration Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ProductValueClass.php');


class cp_product_value_dao{
/*
 * Product Registration CRUD
 */
    public function createProductValue(
        $pProductValueId = null
        , $pProductValueName = null
        , $pValue = null
        , $pValue2 = null
        , $pValue3 = null
        , $pValueUnit = null
        , $pStatus = null
        , $pType = null
        , $pProductId = null
        , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $productId = $idgeneratorhelper->generateId();

        $utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM add_product_value (
              $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11
            )"
            , array(
                $pProductValueId
                , $pProductValueName
                , $pValue
                , $pValue2
                , $pValue3
                , $pValueUnit
                , $pStatus
                , $pType
                , $pCreateDate
                , null
                , $pProductId
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $productId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;

    }


    public function getProductValue(
        $pProductValueId
        , $pProductValueName = null
        , $pValue = null
        , $pValue2 = null
        , $pValue3 = null
        , $pValueUnit = null
        , $pStatus = null
        , $pType = null
        , $pProductId = null
        , $pPageSize = null
        , $pSkipSize = null
        , $pEnterpriseId = null
    ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is p  assed in, it will return a connection string

        $res = pg_query_params($connectionString,
            "SELECT * FROM get_product_value(
                $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11
            )"
            , array(
                $pProductValueId
                , $pProductValueName
                , $pValue
                , $pValue2
                , $pValue3
                , $pValueUnit
                , $pStatus
                , $pType
                , $pProductId
                , $pPageSize
                , $pSkipSize
            ));
            $data = array();
            $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
            $row = $rows[$r];
            $productValueClass = new cp_Product_Value();
            $productValueClass->productValueId = $row["product_value_id"];
            $productValueClass->productValueName = $row["product_value_name"];
            $productValueClass->value = $row["value"];
            $productValueClass->value2 = $row["value2"];
            $productValueClass->value3 = $row["value3"];
            $productValueClass->valueUnit = $row["value_unit"];
            $productValueClass->status = $row["status"];
            $productValueClass->type = $row["type"];
            $productValueClass->createdDate = $row["create_date"];
            $productValueClass->lastUpdate= $row["last_update"];
            $productValueClass->productId= $row["product_id"];
            $productValueClass->totalRows = $row["total_rows"];

            //add row to table
            array_push($data, $productValueClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
        $sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updateProductValue(
        $pProductValueId
        , $pProductValueName = null
        , $pValue = null
        , $pValue2 = null
        , $pValue3 = null
        , $pValueUnit = null
        , $pStatus = null
        , $pType = null
        , $pLastUpdate = null
        , $pProductId = null
        , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM update_product(
                $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
            )"
            , array(
                $pProductValueId
                , $pProductValueName
                , $pValue
                , $pValue2
                , $pValue3
                , $pValueUnit
                , $pStatus
                , $pType
                , $pLastUpdate
                , $pProductId
            ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductValueId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }


    public function deleteProductValue(
	    $pProductValueId
        , $pEnterpriseId = null
	){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
            "SELECT * FROM delete_product_value(
                $1
            )"
            , array(
                $pProductValueId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pProductValueId);

        //free up the buffer memory
        pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();

        //returns the data
        return $retData;
    }

}
 
?>
