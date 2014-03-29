<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceValueDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceSessionDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceRelationshipValueDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/phoneDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/databaseAdapter_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/encryption_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');

class cp_DeviceResController
{
        /* Getting devices with values */
        public function getDeviceDetails(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            $deviceId = null;
            $name = null;
            $code = null;
            $status = null;
            $type = null;
            $type2 = null;
            $push = null;
            $token = null;
            $sms = null;
            $quality= null;
            $resolution = null;
            $deviceValueType = null;
            $ownerId  = null;
            $pageSize = null;
            $skipSize = null;
            $enterpriseId = null;

            if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
            if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
            if (isset($_GET['Name'])){ $name = $_GET['Name']; };
            if (isset($_GET['Code'])){ $code = $_GET['Code']; };
            if (isset($_GET['Status'])){ $status= $_GET['Status']; };
            if (isset($_GET['Type'])){ $type = $_GET['Type']; };
            if (isset($_GET['Type2'])){ $type2 = $_GET['Type2']; };
            if (isset($_GET['Push'])){ $push = $_GET['Push']; };
            if (isset($_GET['Token'])){ $token = $_GET['Token']; };
            if (isset($_GET['Sms'])){ $sms = $_GET['Sms']; };
            if (isset($_GET['Quality'])){ $quality = $_GET['Quality']; };
            if (isset($_GET['Resolution'])){ $resolution = $_GET['Resolution']; };
            if (isset($_GET['DeviceValueType'])){ $deviceValueType = $_GET['DeviceValueType']; };
            if (isset($_GET['EntityId'])){ $ownerId = $_GET['EntityId']; };
            if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
            if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
            if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

            //get the json formatted data
            $deviceDb = new cp_device_dao();
            $deviceRes = $deviceDb->getDeviceDetails(
                $deviceId
                , $name
                , $code
                , $status
                , $type
                , $type2
                , $push
                , $token
                , $sms
                , $quality
                , $resolution
                , $deviceValueType
                , $ownerId
                , $pageSize
                , $skipSize
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($deviceRes)){
                $dataResponse->dataResponse($deviceRes['Data'], $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error'], $deviceRes['TotalRowsAvailable']);
            }else{
                $dataResponse->dataResponse(null, $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error']);
            }
            return;
        }

        /* Getting devices */
        public function getDevices(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            $deviceId = null;
            $name = null;
            $code = null;
            $status = null;
            $type = null;
            $type2 = null;
            $ownerId  = null;
            $pageSize = null;
            $skipSize = null;
            $enterpriseId = null;

            if (isset($_GET['EnterpriseId'])){ $enterpriseId = $_GET['EnterpriseId']; };
            if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
            if (isset($_GET['Name'])){ $name = $_GET['Name']; };
            if (isset($_GET['Code'])){ $code = $_GET['Code']; };
            if (isset($_GET['Status'])){ $status= $_GET['Status']; };
            if (isset($_GET['Type'])){ $type = $_GET['Type']; };
            if (isset($_GET['Type2'])){ $type2 = $_GET['Type2']; };
            if (isset($_GET['EntityId'])){ $ownerId = $_GET['EntityId']; };
            if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };
            if (isset($_GET['PageSize'])){ $pageSize = $_GET['PageSize']; };
            if (isset($_GET['SkipSize'])){ $skipSize = $_GET['SkipSize']; };

            //get the json formatted data
            $deviceDb = new cp_device_dao();
            $deviceRes = $deviceDb->getDevice(
                $deviceId
                , $name
                , $code
                , $status
                , $type
                , $type2
                , $ownerId
                , $pageSize
                , $skipSize
                , $enterpriseId
            );

            if ($databaseHelper->hasDataNoError($deviceRes)){
                $dataResponse->dataResponse($deviceRes['Data'], $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error'], $deviceRes['TotalRowsAvailable']);
            }else{
                $dataResponse->dataResponse(null, $deviceRes['ErrorCode'], $deviceRes['ErrorMessage'], $deviceRes['Error']);
            }
            return;
        }

        /* Adding devices */
        public function addDevice(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            if (isset($_POST['json'])){
                $jsonPost = $_POST['json'];
                $newDevice = json_decode($jsonPost, true);
                $deviceId = null;
                $name = null;
                $code = null;
                $status = null;
                $type = null;
                $type2 = null;
                $description = null;
                $ownerId = null;
                $enterpriseId = null;

                if (isset($newDevice['EnterpriseId'])){ $enterpriseId = $newDevice['EnterpriseId']; };
                if (isset($newDevice['DeviceId'])){ $deviceId = $newDevice['DeviceId']; };
                if (isset($newDevice['Name'])){ $name = $newDevice['Name']; };
                if (isset($newDevice['Code'])){ $code = $newDevice['Code']; };
                if (isset($newDevice['Status'])){ $status = $newDevice['Status']; };
                if (isset($newDevice['Type'])){ $type = $newDevice['Type']; };
                if (isset($newDevice['Type2'])){ $type2 = $newDevice['Type2']; };
                if (isset($newDevice['Description'])){ $description = $newDevice['Description']; };
                if (isset($newDevice['EntityId'])){ $ownerId = $newDevice['EntityId']; };
                if (isset($newDevice['OwnerId'])){ $ownerId = $newDevice['OwnerId']; };


                //get the json formatted data
                $deviceDb = new cp_device_dao();
                $addDeviceRes = $deviceDb->createDevice(
                    $name
                    , $code
                    , $status
                    , $type
                    , $type2
                    , $description
                    , $ownerId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($addDeviceRes)){
                    $dataResponse->dataResponse($addDeviceRes['Id'], $addDeviceRes['ErrorCode'], $addDeviceRes['ErrorMessage'], $addDeviceRes['Error']);
                }else{
                    $dataResponse->dataResponse(null, $addDeviceRes['ErrorCode'], $addDeviceRes['ErrorMessage'], $addDeviceRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }

        /* Adding devices with values */
        public function addDeviceWithValues(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            if (isset($_POST['json'])){
                $jsonPost = $_POST['json'];
                $newDevice = json_decode($jsonPost, true);
                $deviceId = null;
                $name = null;
                $code = null;
                $status = null;
                $type = null;
                $type2 = null;
                $description = null;
                $ownerId  = null;

                $sms = null;
                $push = null;
                $token = null;
                $quality = null;
                $resolution = null;
                $password = null;
                $deviceValueDescription = null;
                $deviceValueType = null;
                $hash = null;
                $salt = null;

                $enterpriseId = null;

                if (isset($newDevice['EnterpriseId'])){ $enterpriseId = $newDevice['EnterpriseId']; };
                if (isset($newDevice['DeviceId'])){ $deviceId = $newDevice['DeviceId']; };
                if (isset($newDevice['Name'])){ $name = $newDevice['Name']; };
                if (isset($newDevice['Code'])){ $code = $newDevice['Code']; };
                if (isset($newDevice['Status'])){ $status = $newDevice['Status']; };
                if (isset($newDevice['Type'])){ $type = $newDevice['Type']; };
                if (isset($newDevice['Type2'])){ $type2 = $newDevice['Type2']; };
                if (isset($newDevice['Description'])){ $description = $newDevice['Description']; };
                if (isset($newDevice['EntityId'])){ $ownerId = $newDevice['EntityId']; };
                if (isset($newDevice['OwnerId'])){ $ownerId = $newDevice['OwnerId']; };

                if (isset($newDevice['Sms'])){ $sms = $newDevice['Sms']; };
                if (isset($newDevice['Push'])){ $push = $newDevice['Push']; };
                if (isset($newDevice['Token'])){ $token = $newDevice['Token']; };
                if (isset($newDevice['Resolution'])){ $resolution = $newDevice['Resolution']; };
                if (isset($newDevice['Quality'])){ $resolution = $newDevice['Quality']; };
                if (isset($newDevice['DeviceValueDescription'])){ $resolution = $newDevice['DeviceValueDescription']; };
                if (isset($newDevice['DeviceValueType'])){ $resolution = $newDevice['DeviceValueType']; };
                if (isset($newDevice['Password'])){ $password = $newDevice['Password']; };


                //get the json formatted data
                $deviceDb = new cp_device_dao();
                $addDeviceRes = $deviceDb->createDevice(
                    $name
                    , $code
                    , $status
                    , $type
                    , $type2
                    , $description
                    , $ownerId
                    , $enterpriseId
                );

                if ($databaseHelper->hasDataNoError($addDeviceRes)){
                    $deviceId = $addDeviceRes['Id'];
                    $deviceValueDb = new cp_create_device_value_dao();
                    $encryptionHelper = new cp_encryption_helper();
                    if ($password != null){
                        $salt = $encryptionHelper->generateSalt();
                        $hash = $encryptionHelper->hash($password, $salt);
                    }

                    $addDeviceValueRes = $deviceValueDb->createDeviceValue(
                        $push
                        , $sms
                        , $token
                        , $deviceValueType
                        , $resolution
                        , $quality
                        , $hash
                        , $salt
                        , $deviceId
                        , $deviceValueDescription
                        , $enterpriseId
                    );
                    if ($databaseHelper->hasDataNoError($addDeviceValueRes)){
                        $dataResponse->dataResponse($addDeviceValueRes['Id'], $addDeviceValueRes['ErrorCode'], $addDeviceValueRes['ErrorMessage'], $addDeviceValueRes['Error']);
                    }else{
                        $dataResponse->dataResponse(null, $addDeviceValueRes['ErrorCode'], $addDeviceValueRes['ErrorMessage'], $addDeviceValueRes['Error']);
                    }
                }else{
                    $dataResponse->dataResponse(null, $addDeviceRes['ErrorCode'], $addDeviceRes['ErrorMessage'], $addDeviceRes['Error']);
                }
                return;
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }

        /* Update devices */
        public function updateDevice(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            $UTChelper = new cp_UTCconvertor_helper();
            $lastUpdate = $UTChelper->getCurrentDateTime();

            if (isset($_POST['json'])){
                $jsonPost = $_POST['json'];
                $updateDevice = json_decode($jsonPost, true);
                $deviceId = null;
                $name = null;
                $code = null;
                $status = null;
                $type = null;
                $type2 = null;
                $description = null;
                $ownerId = null;
                $enterpriseId = null;

                if (isset($updateDevice['EnterpriseId'])){ $enterpriseId = $updateDevice['EnterpriseId']; };
                if (isset($updateDevice['DeviceId'])){ $deviceId = $updateDevice['DeviceId']; };
                if (isset($updateDevice['Name'])){ $name = $updateDevice['Name']; };
                if (isset($updateDevice['Code'])){ $code = $updateDevice['Code']; };
                if (isset($updateDevice['Status'])){ $status = $updateDevice['Status']; };
                if (isset($updateDevice['Type'])){ $type = $updateDevice['Type']; };
                if (isset($updateDevice['Type2'])){ $type2 = $updateDevice['Type2']; };
                if (isset($updateDevice['Description'])){ $description = $updateDevice['Description']; };
                if (isset($updateDevice['EntityId'])){ $ownerId = $updateDevice['EntityId']; };
                if (isset($updateDevice['OwnerId'])){ $ownerId = $updateDevice['OwnerId']; };

                //device Id and ownerId Id is required for editing the device
                if ($deviceId != null && $ownerId != null){
                    //get the json formatted data
                    $deviceDb = new cp_device_dao();
                    $updateDeviceRes = $deviceDb->updateDevice(
                        $deviceId
                        , $name
                        , $code
                        , $status
                        , $type
                        , $type2
                        , $description
                        , $lastUpdate
                        , $ownerId
                        , $enterpriseId
                    );

                    if ($databaseHelper->hasDataNoError($updateDeviceRes)){
                        $dataResponse->dataResponse($updateDeviceRes['Id'], $updateDeviceRes['ErrorCode'], $updateDeviceRes['ErrorMessage'], $updateDeviceRes['Error']);
                    }else{
                        $dataResponse->dataResponse(null, $updateDeviceRes['ErrorCode'], $updateDeviceRes['ErrorMessage'], $updateDeviceRes['Error']);
                    }
                    return;
                }else{
                    $dataResponse->dataResponse(null, -1, 'Device and Entity ID is required', true);
                    return;
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }

        /* Remove devices */
        public function removeDevice(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            if (isset($_POST['json'])){
                $jsonPost = $_POST['json'];
                $deleteDevice = json_decode($jsonPost, true);

                $deviceId = null;
                $enterpriseId = null;

                if (isset($deleteDevice['EnterpriseId'])){ $enterpriseId = $deleteDevice['EnterpriseId']; };
                if (isset($deleteDevice['DeviceId'])){ $deviceId = $deleteDevice['DeviceId']; };

                //device Id is required to delete the device
                if ($deviceId != null){
                    //get the json formatted data
                    $deviceDb = new cp_device_dao();
                    $deleteDeviceRes = $deviceDb->deleteDevice(
                        $deviceId
                        , $enterpriseId
                    );
                    if ($databaseHelper->hasDataNoError($deleteDeviceRes)){
                        $dataResponse->dataResponse($deleteDeviceRes['Id'], $deleteDeviceRes['ErrorCode'], $deleteDeviceRes['ErrorMessage'], $deleteDeviceRes['Error']);
                    }else{
                        $dataResponse->dataResponse(null, $deleteDeviceRes['ErrorCode'], $deleteDeviceRes['ErrorMessage'], $deleteDeviceRes['Error']);
                    }
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }
        }

        public function addDeviceFromApp(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            if (isset($_POST['json'])){
                $jsonPost = $_POST['json'];
                $newDevice = json_decode($jsonPost, true);

                $deviceId = null;
                $code = null; //device code of HXS
                $push = null;
                $sms = null;
                $token = null;
                $resolution = null;
                $quality = null;
                $hash = null;
                $salt = null;
                $name = null;
                $status = null;
                $type = null;
                $type2 = null;
                $deviceType = null;
                $description = null;
                $deviceValueDescription = null;

                $connectedId = null;
                $connectedCode = null;  //device code of connected
                $connectedPush = null;
                $connectedSms = null;
                $connectedToken = null;
                $connectedResolution = null;
                $connectedQuality = null;
                $connectedHash = null;
                $connectedSalt = null;
                $connectedName = null;
                $connectedStatus = null;
                $connectedType = null;
                $connectedType2 = null;
                $connectedDeviceType = null;
                $connectedDescription = null;
                $connectedDeviceValueDescription = null;

                $relationshipName = null;
                $ownerId = null;

                //Parent Device
                if (isset($newDevice['Code'])){ $code = $newDevice['Code']; };
                if (isset($newDevice['Push'])){ $push = $newDevice['Push']; };
                if (isset($newDevice['Sms'])){ $sms = $newDevice['Sms']; };
                if (isset($newDevice['Token'])){ $token = $newDevice['Token']; };
                if (isset($newDevice['Resolution'])){ $resolution = $newDevice['Resolution']; };
                if (isset($newDevice['Quality'])){ $quality = $newDevice['Quality']; };
                if (isset($newDevice['Hash'])){ $hash = $newDevice['Hash']; };
                if (isset($newDevice['Salt'])){ $salt = $newDevice['Salt']; };
                if (isset($newDevice['Name'])){ $name = $newDevice['Name']; };
                if (isset($newDevice['Status'])){ $status = $newDevice['Status']; };
                if (isset($newDevice['Type'])){ $type = $newDevice['Type']; };
                if (isset($newDevice['Type2'])){ $type2 = $newDevice['Type2']; };
                if (isset($newDevice['DeviceType'])){ $deviceType = $newDevice['DeviceType']; };
                if (isset($newDevice['Description'])){ $deviceValueDescription = $newDevice['Description']; };
                if (isset($newDevice['DeviceValueDescription'])){ $description = $newDevice['DeviceValueDescription']; };

                //Connected Device
                if (isset($newDevice['ConnectedCode'])){ $connectedCode = $newDevice['ConnectedCode']; };
                if (isset($newDevice['ConnectedPush'])){ $connectedPush = $newDevice['ConnectedPush']; };
                if (isset($newDevice['ConnectedSms'])){ $connectedSms = $newDevice['ConnectedSms']; };
                if (isset($newDevice['ConnectedToken'])){ $connectedToken = $newDevice['ConnectedToken']; };
                if (isset($newDevice['ConnectedResolution'])){ $connectedResolution = $newDevice['ConnectedResolution']; };
                if (isset($newDevice['ConnectedQuality'])){ $connectedQuality = $newDevice['ConnectedQuality']; };
                if (isset($newDevice['ConnectedHash'])){ $connectedHash = $newDevice['ConnectedHash']; };
                if (isset($newDevice['ConnectedSalt'])){ $connectedSalt = $newDevice['ConnectedSalt']; };
                if (isset($newDevice['ConnectedName'])){ $connectedName = $newDevice['ConnectedName']; };
                if (isset($newDevice['ConnectedStatus'])){ $connectedStatus = $newDevice['ConnectedStatus']; };
                if (isset($newDevice['ConnectedType'])){ $connectedType = $newDevice['ConnectedType']; };
                if (isset($newDevice['ConnectedType2'])){ $connectedType2 = $newDevice['ConnectedType2']; };
                if (isset($newDevice['ConnectedDeviceType'])){ $connectedDeviceType = $newDevice['ConnectedDeviceType']; };
                if (isset($newDevice['ConnectedDescription'])){ $connectedDescription = $newDevice['ConnectedDescription']; };
                if (isset($newDevice['ConnectedDeviceValueDescription'])){ $connectedDeviceValueDescription = $newDevice['ConnectedDeviceValueDescription']; };

                //Entity Details
                if (isset($newDevice['EntityId'])){ $ownerId = $newDevice['EntityId']; };
                if (isset($newDevice['OwnerId'])){ $ownerId = $newDevice['OwnerId']; };


                //check if connected device is already registered in the database. If not, add the connected device (iPhone) into the database
                $deviceDb = new cp_device_dao();
                $deviceRelationshipDb = new cp_device_relationship_dao();
                $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
                $deviceSessionDb = new cp_device_session_dao();

                //CONNECTED DEVICE
                //check duplicates of the connected device
                $getConnectedDeviceRes = $deviceDb->getDevice(
                    null
                    , null
                    , $connectedCode
                    , null
                    , null
                    , null
                    , null
                );

                if ($getConnectedDeviceRes["TotalRowsAvailable"] > 0){
                    $connectedDeviceId = $getConnectedDeviceRes["Data"][0]->deviceId;
                    //if there are existing, check if user is already register to id
                    $getConnectedDeviceRelationshipRes = $deviceRelationshipDb->getDeviceRelationship(
                        null
			            , $connectedDeviceId
                        , $ownerId
                        , null
                        , null
                    );
                    if ($getConnectedDeviceRelationshipRes["TotalRowsAvailable"] > 0){
                        //current user is related to this device
                    }else{
                        //add the relationship of the user with the device
                        $createConnectedDeviceRelationshipRes = $deviceRelationshipDb->createDeviceRelationship(
                            $relationshipName
                            , $connectedDeviceId
                            , null
                            , $ownerId
                        );
                        if ($databaseHelper->hasDataNoError($createConnectedDeviceRelationshipRes)){
                        }else{
                            $dataResponse->dataResponse(null, -1, "Unable to add relate user to connected device", true);
                            return;
                        }
                    }
                }else{
                    //add the connected device
                    $createConnectedDeviceRes = $deviceRelationshipDb->createEntityDeviceRelationshipWithValue(
                        $connectedName
                        , $connectedCode
                        , $connectedStatus
                        , $connectedType
                        , $connectedType2
                        , $connectedDescription
                        , $ownerId
                        , $ownerId
                        , $connectedName
                        , $connectedPush
                        , $connectedSms
                        , $connectedToken
                        , $connectedDeviceType
                        , $connectedResolution
                        , $connectedQuality
                        , $connectedHash
                        , $connectedSalt
                        , $connectedDeviceValueDescription
                    );

                    //To get Connected Device ID
                    $getAddedConnectedDeviceRes = $deviceDb->getDevice(
                    	null
                    	, null
                    	, $connectedCode
                    	, null
                    	, null
                    	, null
                    	, null
                    );
                    if ($getAddedConnectedDeviceRes["TotalRowsAvailable"] > 0){
                        $connectedDeviceId = $getAddedConnectedDeviceRes["Data"][0]->deviceId;
		    }
                };

                //PARENT DEVICE
                //check duplicates of the parent device
                $getConnectedDeviceRes = $deviceDb->getDevice(
                    null
                    , null
                    , $code
                    , null
                    , null
                    , null
                    , null
                );

                if ($getConnectedDeviceRes["TotalRowsAvailable"] > 0){
                    $deviceId = $getConnectedDeviceRes["Data"][0]->deviceId;
                    //if there are existing, check if user is already register to id
                    $getDeviceRelationshipRes = $deviceRelationshipDb->getDeviceRelationship(
                        null
			, $deviceId
                        , $ownerId
                        , null
                        , null
                    );
                    if ($getDeviceRelationshipRes["TotalRowsAvailable"] > 0){
                        //current user is related to this device
			$dataResponse->dataResponse(null, -1, "Unable to add relate user to parent device, Duplicated", true);
                        return;
                    }else{
                        //add the relationship of the user with the device
                        $createDeviceRelationshipRes = $deviceRelationshipDb->createDeviceRelationship(
                            $deviceId
                            , $ownerId
                        );
                        if ($databaseHelper->hasDataNoError($createDeviceRelationshipRes)){
			    $createDeviceRelationshipValueRes = $deviceRelationshipValueDb->createDeviceRelationshipValue(
			    	$name
			    	, $push
			    	, $sms
			    	, $token
			    	, $deviceType
			    	, $resolution
			    	, $quality
			    	, $hash
			    	, $salt
			    	, $createDeviceRelationshipRes["Id"]
			    	, $deviceValueDescription
			    );
				
                        }else{
                            $dataResponse->dataResponse(null, -1, "Unable to add relate user to parent device", true);
                            return;
                        }
                    }
                }else{
                    //add the parent device
                    $createDeviceRelationshipRes = $deviceRelationshipDb->createEntityDeviceRelationshipWithValue(
                        $name
                        , $code
                        , $status
                        , $type
                        , $type2
                        , $description
                        , $ownerId
                        , $ownerId
                        , $name
                        , $push
                        , $sms
                        , $token
                        , $deviceType
                        , $resolution
                        , $quality
                        , $hash
                        , $salt
                        , $deviceValueDescription
                    );
                    //To get Device ID
                    $getAddedConnectedDeviceRes = $deviceDb->getDevice(
                    	null
                    	, null
                    	, $code
                    	, null
                    	, null
                    	, null
                    	, null
                    );
                    if ($getAddedConnectedDeviceRes["TotalRowsAvailable"] > 0){
                        $deviceId = $getAddedConnectedDeviceRes["Data"][0]->deviceId;
		    }
                };

                //After making sure both device and connected device are added and related to user, we will create the session
                if ($deviceId != null && $connectedDeviceId != null){
                    //create a session between both devices
                    $createDeviceSessionRes = $deviceSessionDb->createDeviceSession(
                        $deviceId
                        , $connectedDeviceId
                        , null
                    );
                    if ($databaseHelper->hasDataNoError($createDeviceSessionRes)){
                        $dataResponse->dataResponse($createDeviceRelationshipRes["Id"], $createDeviceRelationshipRes['ErrorCode'], $createDeviceRelationshipRes['ErrorMessage'], $createDeviceRelationshipRes['Error']);
                    }else{
                        $dataResponse->dataResponse(null, $createDeviceRelationshipRes['ErrorCode'], $createDeviceRelationshipRes['ErrorMessage'], $createDeviceRelationshipRes['Error']);
                    }
                }else{
                    //if code is not stated, do not add
                    $dataResponse->dataResponse(null, -1, "Both devices are not ready to be connected", true);
                    return;
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
                return;
            }

        }

        public function removeDeviceFromApp(){
            	$dataResponse = new cp_resData_helper();
        	$databaseHelper = new cp_databaseAdapter_helper();

		if (isset($_POST['json'])){
		    $jsonPost = $_POST['json'];
		    $deleteEntityDeviceRelationshipWithValues = json_decode($jsonPost, true);

		    $deviceRelationshipId = null;
		    $deviceRelationshipValueId =  null;

		    if (isset($deleteEntityDeviceRelationshipWithValues['DeviceRelationshipId'])){ $deviceRelationshipId = $deleteEntityDeviceRelationshipWithValues['DeviceRelationshipId']; };
		    if (isset($deleteEntityDeviceRelationshipWithValues['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $deleteEntityDeviceRelationshipWithValues['DeviceRelationshipValueId']; };

		    //device Id is required to delete the device
		    if ($deviceRelationshipId != null && $deviceRelationshipValueId != null){
		        //get the json formatted data
		        $deviceRelationshipDb = new cp_device_relationship_dao();
		        $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
		        $deleteDeviceRelationshipRes = $deviceRelationshipDb->deleteDeviceRelationship(
		            $deviceRelationshipId
		        );

		        if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipRes)){
		            $deleteDeviceRelationshipValueRes = $deviceRelationshipValueDb->deleteDeviceRelationshipValue(
		                $deviceRelationshipValueId
		            );
		            if ($databaseHelper->hasDataNoError($deleteDeviceRelationshipValueRes)){
		                $dataResponse->dataResponse($deleteDeviceRelationshipRes['Id'], $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
		                return;
		            }else{
		                $dataResponse->dataResponse(null, -1, "Invalid Request", true);
		                return;
		            }
		        }else{
		            $dataResponse->dataResponse(null, $deleteDeviceRelationshipRes['ErrorCode'], $deleteDeviceRelationshipRes['ErrorMessage'], $deleteDeviceRelationshipRes['Error']);
		        }
		    }else{
		        $dataResponse->dataResponse(null, -1, "Invalid Request", true);
		        return;
		    }
		}else{
		    $dataResponse->dataResponse(null, -1, "Invalid Request", true);
		    return;
		}
        }

        public function getDevicesFromApp(){
            $dataResponse = new cp_resData_helper();
            $databaseHelper = new cp_databaseAdapter_helper();

            $deviceId = null;
            $name = null;
            $code = null;
            $status = null;
            $type = null;
            $type2 = null;
            $ownerId  = null;
            $connectedDeviceId  = null;

            if (isset($_GET['DeviceId'])){ $deviceId = $_GET['DeviceId']; };
            if (isset($_GET['Name'])){ $name = $_GET['Name']; };
            if (isset($_GET['Code'])){ $code = $_GET['Code']; };
            if (isset($_GET['Status'])){ $status= $_GET['Status']; };
            if (isset($_GET['Type'])){ $type = $_GET['Type']; };
            if (isset($_GET['Type2'])){ $type2 = $_GET['Type2']; };
            if (isset($_GET['EntityId'])){ $ownerId = $_GET['EntityId']; };
            if (isset($_GET['OwnerId'])){ $ownerId = $_GET['OwnerId']; };


            //get the json formatted data
            $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
            $entityDeviceRelationshipRes = $deviceRelationshipValueDb->getUserDevicesDetails(
            	$ownerId
            );

            if ($databaseHelper->hasDataNoError($entityDeviceRelationshipRes)){
                $dataResponse->dataResponse($entityDeviceRelationshipRes['Data'], $entityDeviceRelationshipRes['ErrorCode'], $entityDeviceRelationshipRes['ErrorMessage'], $entityDeviceRelationshipRes['Error'], $entityDeviceRelationshipRes['TotalRowsAvailable']);
            }else{
                $dataResponse->dataResponse(null, $entityDeviceRelationshipRes['ErrorCode'], $entityDeviceRelationshipRes['ErrorMessage'], $entityDeviceRelationshipRes['Error']);
            }
            return;
        }

        public function updateDeviceFromApp(){
        $dataResponse = new cp_resData_helper();
        $databaseHelper = new cp_databaseAdapter_helper();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $updateDeviceAndDeviceRelationshipWithValues = json_decode($jsonPost, true);

            $deviceId = null;
            $deviceOwnerId = null;
            $deviceRelationshipId = null;
            $deviceRelationshipValueId = null;

            //device variables
            $deviceName = null;
            $deviceCode = null;
            $deviceStatus = null;
            $deviceType = null;
            $deviceType2 = null;
            $deviceDescription = null;
            $deviceLastUpdate = null;

            //device relationship value variables
            $name = null;
            $push = null;
            $sms = null;
            $token = null;
            $type = null;
            $resolution = null;
            $quality = null;
            $hash = null;
            $description = null;
            $password = null;
            $deviceRelationshipValueLastUpdate = null;


           // if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipId'])){ $deviceRelationshipId = $updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueId'])){ $deviceRelationshipValueId = $updateDeviceAndDeviceRelationshipWithValues['DeviceRelationshipValueId']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Name'])){ $deviceName= $updateDeviceAndDeviceRelationshipWithValues['Name']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Code'])){ $deviceCode = $updateDeviceAndDeviceRelationshipWithValues['Code']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Status'])){ $deviceStatus = $updateDeviceAndDeviceRelationshipWithValues['Status']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Type'])){ $deviceType = $updateDeviceAndDeviceRelationshipWithValues['Type']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Type2'])){ $deviceType2 = $updateDeviceAndDeviceRelationshipWithValues['Type2']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Description'])){ $deviceDescription = $updateDeviceAndDeviceRelationshipWithValues['Description']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['LastUpdate'])){ $deviceRelationshipValueLastUpdate = $updateDeviceAndDeviceRelationshipWithValues['LastUpdate']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Push'])){ $push = $updateDeviceAndDeviceRelationshipWithValues['Push']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Name'])){ $name = $updateDeviceAndDeviceRelationshipWithValues['Name']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Sms'])){ $sms = $updateDeviceAndDeviceRelationshipWithValues['Sms']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Token'])){ $token = $updateDeviceAndDeviceRelationshipWithValues['Token']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['DeviceType'])){ $type = $updateDeviceAndDeviceRelationshipWithValues['DeviceType']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Resolution'])){ $resolution = $updateDeviceAndDeviceRelationshipWithValues['Resolution']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Quality'])){ $quality = $updateDeviceAndDeviceRelationshipWithValues['Quality']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Hash'])){ $hash = $updateDeviceAndDeviceRelationshipWithValues['Hash']; };
            if (isset($updateDeviceAndDeviceRelationshipWithValues['Description'])){ $description = $updateDeviceAndDeviceRelationshipWithValues['Description']; };

            $deviceRelationshipValueDb = new cp_device_relationship_value_dao();
	    if($deviceRelationshipValueId){
		//update the device relationship value
		$updateDeviceValueRes = $deviceRelationshipValueDb->updateDeviceRelationshipValue(
		    $deviceRelationshipValueId
		    , $name
		    , $push
		    , $sms
		    , $token
		    , $type
		    , $resolution
		    , $quality
		    , $hash
		    , null
		    , $deviceRelationshipValueLastUpdate
		    , null
		    , $description
		);
		if ($databaseHelper->hasDataNoError($updateDeviceValueRes)){
		    $dataResponse->dataResponse($updateDeviceValueRes['Id'], $updateDeviceValueRes['ErrorCode'], $updateDeviceValueRes['ErrorMessage'], $updateDeviceValueRes['Error']);
		    return;
		}else{
		    $dataResponse->dataResponse(null, -1, "Invalid Request", true);
		    return;
		}
	    }else{
		$dataResponse->dataResponse(null, -1, "deviceRelationshipValueId not found", true);
                return;
	    }
        }else{
            $dataResponse->dataResponse(null, -1, "Invalid Request", true);
            return;
        }
    }
}
?>
