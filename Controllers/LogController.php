<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authorization_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/logDao.php');
class LogController
{
    public function index(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");

        //get the device name
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $userHelper = new cp_user_helper();
        $view = new cp_view_helper();

        $deviceId = null;
        $entityId = $userHelper->getCurrentEntityId();
        //get the deviceId
        if (isset($_GET['id'])){ $deviceId = $_GET['id']; };
        if ($deviceId){
            $resDevice = $deviceRelationshipDb->getEntityDeviceRelationshipValue(
                $deviceId
                ,$entityId
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
                ,null
            );

            if ($resDevice['Error'] == false){
                $deviceData = $resDevice['Data'][0];
                $deviceName = $deviceData->name;
                $type = $deviceData->deviceType;
                echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Log/logs.php', array(
                    "deviceId" => $deviceId,
                    "deviceName" => $deviceName,
                    "type" => $type
                ));
            }else{
                //invalid request
                header( 'Location:/error/invalid'); //unable to find device
            }
        }else{
            echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Log/logs.php', array());
        }

    }
}
?>
