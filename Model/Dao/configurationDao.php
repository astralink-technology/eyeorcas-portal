<?php
/*
 * Configuration DAO
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/ConfigurationClass.php');

class cp_configuration_dao{
    public function createConfiguration(
            $name = null
            , $file_url = null
            , $value = null
            , $value2 = null
            , $value3 = null
            , $value_hash = null
            , $value2_hash = null
            , $value3_hash = null
            , $description = null
            , $type = null
            , $enterpriseId = null
            ){
       
        $idgeneratorhelper = new cp_idGenerator_helper();
        $configuration_id = $idgeneratorhelper->generateId();
	$utcHelper = new cp_UTCconvertor_helper();
        $createDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(); // if nothing is passed in, it will return a connection string
        
        $res = pg_query_params($connectionString, 
            "SELECT add_configuration(
                $1 
                , $2
                , $3
                , $4
                , $5
                , $6
                , $7
                , $8
                , $9
                , $10
                , $11
                , $12
                , $13
                , $14
            )",
                array(
                $configuration_id
                , $name
		        , $file_url
                , $value
                , $value2
                , $value3
                , $value_hash
                , $value2_hash
                , $value3_hash
                , $description
                , $type
                , $enterpriseId
                , $createDate
                , null
                )
                );
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $configuration_id);
        
        //free up the buffer memory
	    pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
    
    public function getConfiguration(
            $configurationId
            , $name = null
            , $type = null
            , $enterpriseId = null
            , $pageSize = null
            , $skipSize = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true);
        
	    $res = pg_query_params($connectionString,
                "SELECT * FROM get_configuration(
                    $1
                    , $2
                    , $3
                    , $4
                    , $5
                    , $6
                )"
                , array(
                    $configurationId
                    , $name
                    , $type
                    , $enterpriseId
                    , $pageSize
                    , $skipSize
                ));
        $data = array();
	    $rows = pg_fetch_all($res);

        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $configurationClass = new cp_Configuration();
                $configurationClass->configurationId = $row["configuration_id"];
                $configurationClass->name = $row["name"];
                $configurationClass->fileUrl = $row["file_url"];
                $configurationClass->value = $row["value"];
                $configurationClass->value2 = $row["value2"];
                $configurationClass->value3 = $row["value3"];
                $configurationClass->valueHash = $row["value_hash"];
                $configurationClass->value2Hash = $row["value2_hash"];
                $configurationClass->value3Hash = $row["value3_hash"];
                $configurationClass->description = $row["description"];
                $configurationClass->type = $row["type"];
                $configurationClass->enterpriseId = $row["enterprise_id"];
                $configurationClass->createDate = $row["create_date"];
                $configurationClass->lastUpdate = $row["last_update"];
                $configurationClass->totalRows = $row["total_rows"];
                //add row to table
                array_push($data, $configurationClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
        $sqlconnecthelper->dbDisconnect();
        return $retData;
    }

    public function updateConfiguration(
            $pConfiguration_id
            , $pName = null
            , $pFileUrl = null
            , $pValue = null
            , $pValue2 = null
            , $pValue3 = null
            , $pValueHash = null
            , $pValue2Hash = null
            , $pValue3Hash = null
            , $pDescription = null
            , $pType = null
            , $pEnterpriseId = null
            , $pLastUpdate = null
            ){
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_configuration(
                    $1 
                    , $2
                    , $3
                    , $4
                    , $5
                    , $6
                    , $7
                    , $8
                    , $9
                    , $10
                    , $11
                    , $12
                    , $13
                )"
                , array(
                    $pConfiguration_id
                    , $pName
                    , $pFileUrl
                    , $pValue
                    , $pValue2
                    , $pValue3
                    , $pValueHash
                    , $pValue2Hash
                    , $pValue3Hash
                    , $pDescription
                    , $pType
                    , $pEnterpriseId
                    , $pLastUpdate
                    ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pConfiguration_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

    public function deleteConfiguration(
            $configuration_id
            ){
	$sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_configuration(
                $1
            )"
            , array(
                $configuration_id
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $configuration_id);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }
}
 
?>
