<?php
/*
 * Phone Controller
 */
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/idgenerator_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Classes/PhoneClass.php');


class cp_phone_dao{
/*
 * Phone CRUD
 */
    public function createPhone(
            $pPhoneDigits = null
            , $pDigits = null
            , $pCountryCode = null
            , $pCode = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $idgeneratorhelper = new cp_idGenerator_helper();
        $phoneId = $idgeneratorhelper->generateId();
	
	$utcHelper = new cp_UTCconvertor_helper();
        $pCreateDate = $utcHelper->getCurrentDateTime();
        
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString, 
            "SELECT * FROM add_phone (
            $1, $2, $3, $4, $5, $6, $7, $8
            )"
            , array(
            $phoneId
            , $pPhoneDigits
            , $pDigits
	        , $pCountryCode
            , $pCode
            , $pCreateDate
            , null
            , $pOwnerId
            ));
        
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $phoneId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function getPhone(
            $pPhoneId
            , $pPhoneDigits = null
            , $pDigits = null
            , $pCountryCode = null
            , $pCode = null
            , $pOwnerId = null
            , $pPageSize = null
            , $pSkipSize = null
        , $pEnterpriseId = nulls
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string

	        $res = pg_query_params($connectionString,
                "SELECT * FROM get_phone(
                    $1, $2, $3, $4, $5, $6, $7, $8
                )"
                , array(
                    $pPhoneId
                    , $pPhoneDigits
                    , $pDigits
                    , $pCountryCode
                    , $pCode
                    , $pOwnerId
                    , $pPageSize
                    , $pSkipSize
                ));
        $data = array();
	    $rows = pg_fetch_all($res);


        for($r = 0; $r < count($rows); $r++){
                $row = $rows[$r];
                $phoneClass = new cp_Phone();
                $phoneClass->phoneId = $row["phone_id"];
                $phoneClass->phoneDigits = $row["phone_digits"];
                $phoneClass->digits = $row["digits"];
                $phoneClass->countryCode = $row["country_code"];
                $phoneClass->code = $row["code"];
                $phoneClass->createDate = $row["create_date"];
                $phoneClass->lastUpdate = $row["last_update"];
                $phoneClass->ownerId = $row["owner_id"];
                $phoneClass->totalRows = $row["total_rows"];

                //add row to table
                array_push($data, $phoneClass);
        }

        $rowsRet = pg_num_rows($res);
        $dataAdapter = new cp_databaseAdapter_helper();
        $retData = $dataAdapter->retDataResponse($res, $data, $rowsRet);
	    $sqlconnecthelper->dbDisconnect();
        return $retData;
        
    }

    public function updatePhone(
            $pPhoneId
            , $pPhoneDigits = null
            , $pDigits = null
            , $pCountryCode = null
            , $pCode = null
            , $pLastUpdate = null
            , $pOwnerId = null
            , $pEnterpriseId = null
            ){

        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
        $res = pg_query_params($connectionString,
                "SELECT * FROM update_phone(
                    $1, $2, $3, $4, $5, $6, $7
                )"
                , array(
                    $pPhoneId
                    , $pPhoneDigits
                    , $pDigits
                    , $pCountryCode
                    , $pCode
                    , $pLastUpdate
                    , $pOwnerId
                    ));

        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pPhoneId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }


    public function deletePhone(
            $pPhoneId
	        , $pOwnerId
            , $pEnterpriseId = null
            ){
        $sqlconnecthelper = new cp_sqlConnection_helper();
        $connectionString = $sqlconnecthelper->dbConnect(true, $pEnterpriseId); // if nothing is passed in, it will return a connection string
         $res = pg_query_params($connectionString, 
            "SELECT * FROM delete_phone(
                $1, $2
            )"
            , array(
                $pPhoneId
	        , $pOwnerId
            ));
        $databaseAdapterHelper = new cp_databaseAdapter_helper();
        $retData = $databaseAdapterHelper->retLastInsertId($res, $pPhoneId);
        
        //free up the buffer memory
	pg_free_result($res);
        $sqlconnecthelper->dbDisconnect();
        
        //returns the data
        return $retData;
    }

}
 
?>
