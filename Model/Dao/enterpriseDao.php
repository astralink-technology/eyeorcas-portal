<?php
/*
 * Enterprise DAO
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/EnterpriseClass.php');

class cp_enterprise_dao{
    public function createEnterprise(
            $name = null
            , $code = null
            , $description = null
            , $pTargetEnterpriseId = null
            ){
       
        $idgeneratorhelper = new cp_idGenerator_helper();
        $enterprise_id = $idgeneratorhelper->generateId();
	    $utcHelper = new cp_UTCconvertor_helper();
        $createDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pTargetEnterpriseId); // if nothing is passed in, it will return a connection string
        
        $res = pg_query_params($connectionString, 
            "SELECT add_enterprise(
                $1 
                , $2
                , $3
                , $4
                , $5
                , $6
            )", 
                array(
                $enterprise_id 
                , $name
                , $code
                , $description
                , $createDate
                , null
                )
            );
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $enterprise_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
    
    public function getEnterprise(
            $enterpriseId
            , $name = null
	        , $code = null
	        , $pPageSize = null
	        , $pSkipSize = null
            , $pTargetEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();

        $connectionString = $sqlconnecthelper->dbConnect(true, $pTargetEnterpriseId); // if nothing is passed in, it will return a connection string

	    $res = pg_query_params($connectionString,
                "SELECT * FROM get_enterprise(
                      $1
                      , $2
                      , $3
                      , $4
                      , $5
                )"
                , array(
                    $enterpriseId
                    , $name
                    , $code
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	$rows = pg_fetch_all($res);

        
        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $enterpriseClass = new cp_Enterprise();
                $enterpriseClass->enterpriseId = $row["enterprise_id"];
                $enterpriseClass->name = $row["name"];
                $enterpriseClass->code = $row["code"];
                $enterpriseClass->description = $row["description"];
                $enterpriseClass->createDate = $row["create_date"];
                $enterpriseClass->lastUpdate = $row["last_update"];
                $enterpriseClass->totalRows = $row["total_rows"];
                //add row to table
                array_push($data, $enterpriseClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
    	$sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function updateEnterprise(
            $pEnterprise_id //mandatory
            , $pName = null
            , $pCode = null
            , $pDescription = null
            , $pLastUpdate = null
            , $pTargetEnterpriseId = null
            ){
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pTargetEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_enterprise(
                    $1 
                    , $2
                    , $3
                    , $4
                    , $5
                )"
                , array(
                    $pEnterprise_id
                    , $pName
                    , $pCode
                    , $pDescription
                    , $pLastUpdate
                    ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEnterprise_id);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteEnterprise(
            $pEnterprise_id
            , $pTargetEnterpriseId = null
            ){
	    $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pTargetEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_enterprise(
                $1
            )"
            , array(
                $pEnterprise_id
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pEnterprise_id);
        
        //free up the buffer memory
    	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
}
 
?>
