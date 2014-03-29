<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authorization_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/user_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class DeviceController
{
    public function index(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");
        
        //render the page view
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Device/myDevices.php', array());
    }

    public function settings(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");


        //get the device name
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $userHelper = new cp_user_helper();
        if (isset($_GET['id']) && $_GET['id'] != null){
            //get the deviceId
            $deviceId = $_GET['id'];
            $entityId = $userHelper->getCurrentEntityId();
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
		        $deviceCode = $deviceData->deviceCode;
		        $type = $deviceData->deviceType;
                //render the page view
                $view = new cp_view_helper();
                echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Device/deviceSettings.php', array(
                        "deviceId" => $deviceId,
                        "deviceName" => $deviceName,
                        "type" => $type,
			            "deviceCode" => $deviceCode
                    ));
            }else{
                //invalid request
                header( 'Location:/error/invalid'); //unable to find device
            }
        }else{
            //invalid request
            header( 'Location:/error/invalid');
        }
    }

    public function overview(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");

        //get the device name
        $deviceRelationshipDb = new cp_device_relationship_dao();
        $userHelper = new cp_user_helper();
        if (isset($_GET['id']) && $_GET['id'] != null){
            //get the deviceId
            $deviceId = $_GET['id'];
            $entityId = $userHelper->getCurrentEntityId();
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
		        $deviceCode = $deviceData->deviceCode;
		        $type = $deviceData->deviceType;
                //render the page view
                $view = new cp_view_helper();
                echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Device/overview.php', array(
                        "deviceId" => $deviceId,
                        "deviceName" => $deviceName,
                        "type" => $type,
			            "deviceCode" => $deviceCode
                    ));
            }else{
                //invalid request
                header( 'Location:/error/invalid'); //unable to find device
            }
        }else{
            //invalid request
            header( 'Location:/error/invalid');
        }
    }
//
//    public function viewers(){
//        //only users are allowed;
//        $authorizationHelper = new cp_authorization_helper();
//        $authorizationHelper->setUserAuthorization("/home");
//
//        //render the page view
//        $view = new cp_view_helper();
//        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Device/viewers.php', array());
//    }
 
}
?>
