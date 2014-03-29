<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
class cp_EntityResController
{
    public function getEntity(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $entityId = null;
        $authenticationId  = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['EntityId'])){ $entityId = $_GET['EntityId']; };
        if (isset($_GET['AuthenticationId'])){  $authenticationId = $_GET['AuthenticationId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $entityDb = new cp_entity_dao();
        $entityRes = $entityDb->getEntity(
            $entityId
            , $authenticationId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($entityRes)){
            $dataResponse->dataResponse($entityRes['Data'], $entityRes['ErrorCode'], $entityRes['ErrorMessage'], $entityRes['Error'], $entityRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
        }
        return;
    }

    public function getAdminEntityDetails(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        $entityId = null;
        $authenticationId  = null;
        $pageSize = null;
        $skipSize = null;
        $enterpriseId = null;

        if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
        if (isset($_GET['EntityId'])){ $entityId = $_GET['EntityId']; };
        if (isset($_GET['AuthenticationId'])){  $authenticationId = $_GET['AuthenticationId']; };
        if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
        if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

        //get the json formatted data
        $entityDb = new cp_entity_dao();
        $entityRes = $entityDb->getAdminEntityDetail(
            $entityId
            , $authenticationId
            , $pageSize
            , $skipSize
            , $enterpriseId
        );

        if ($databaseHelper->hasDataNoError($entityRes)){
            $dataResponse->dataResponse($entityRes['Data'], $entityRes['ErrorCode'], $entityRes['ErrorMessage'], $entityRes['Error'], $entityRes['TotalRowsAvailable']);
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
        }
        return;
    }
}
?>
