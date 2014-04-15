<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/encryption_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authentication_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/authorization_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/sqlconnection_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/view_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/mailSender_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/resData_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/UTCconvertor_helper.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Helpers/user_helper.php');

require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/authenticationDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/productRegistrationDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/emailDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/deviceDao.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/productDao.php');

class AccountController
{
    public function index(){
        //default action here
    }

    public function signup(){ 
        if (isset($_POST['json'])){
            $userHelper = new cp_user_helper();
            $entityId = $userHelper->getCurrentEntityId();
            if ($entityId != null){
                header( 'Location:/account/loggedin');
                return;
            }

            $jsonPost = $_POST['json'];
            $newentity = json_decode($jsonPost, true);
            $dataResponse = new cp_resData_helper();
            $authenticationHelper = new cp_authentication_helper();
            $utcHelper = new cp_UTCconvertor_helper();

            $first_name = $newentity['GivenName'];
            $last_name = $newentity['FamilyName'];
            $email = $newentity['Email'];
            $password = $newentity['Password'];
            $status = 'V';
            $approved = true;
            $type = '1';

            $authenticationId = "";

            //check if authentication exists
            $checkUserExists = $authenticationHelper->checkAuthenticationUserExists(strtolower($email));
            if ($checkUserExists == false){
                $authenticationDao = new cp_authentication_dao();
                $emailLower = strtolower($email);

                //create a hashed password from here
                $encryption = new cp_encryption_helper();
                $newHash = $encryption->hash($password);
                $resAuthentication = $authenticationDao->createAuthentication(
                        $email
                        , $emailLower
                        , $newHash
                        , NULL
                            );

                $authenticationId = $resAuthentication['Id'];
                if ($resAuthentication['Error'] == false){
                    //insert a new entity
                    $entityDao = new cp_entity_dao();
                    $nickName = $first_name . " " . $last_name;
                    $resEntity = $entityDao->createEntity(
                            $first_name
                            , $last_name
                            , $nickName
                            , $status
                            , $approved
                            , $type
                            , $authenticationId
                            , null
                            , null
                            );
                    if ($resEntity['Error'] == false){
                        $entityId = $resEntity['Id'];
                        if ($entityId != NULL){
                            //insert the email
                            $emailDao = new cp_email_dao();
                            $resEmail = $emailDao->createEmail(
                                    $email
                                    , $entityId
                                );
                            if ($resEmail['Error'] == false){
                                $emailId = $resEmail['Id'];
                                if ($emailId != NULL || $email != NULL){
                                    //update dao with the latest email
                                    $entityDao->updateEntity(
                                            $entityId
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , $emailId
                                            , null
                                            , $utcHelper->getCurrentDateTime()
                                            );

                                    //get the alpha starter product
                                    $productDao = new cp_product_dao();
                                    $resProduct = $productDao->getProduct(
                                        null
                                        , null
                                        , null
                                        , null
                                        , 'EYEORCAS-STARTER'
                                    );
                                    if ($resProduct['Error'] == false && $resProduct["TotalRowsAvailable"] > 0){
                                        $productRegistrationDao = new cp_product_registration_dao();
                                        $productId = $resProduct['Data'][0]->productId;
                                        $productRegistrationDao->createProductRegistration(
                                            'V'
                                            , null
                                            , $productId
                                            , $entityId
                                        );

                                        $mail = new cp_mailSender_helper();
                                        $receiverEmail = $email;
                                        $receiverName = $first_name . " " . $last_name;

                                        //FIX ME, CONVERT THIS TO HTML EMAIL
                                        $subject = "Welcome to Eye Orcas";
                                        $htmlBody = "Dear " . $first_name .",<br><br> Thank you for signing up with eyeOrcas.<br> ";
                                        $htmlBody .= "<br>Thank you for signing up with us.<br>";
                                        $htmlBody .= "Verify your account within 3 days by clicking on this link - ". "http://" . $_SERVER['HTTP_HOST'] . "/account/verify?code=" . $entityId;
                                        $htmlBody .= "<br><br>Best Regards,<br>";
                                        $htmlBody .= "Eye Orcas";

                                        $mail->sendMail(
                                            $receiverName
                                            , $receiverEmail
                                            , true
                                            , $subject
                                            , $htmlBody
                                            , null
                                        );

                                        $dataResponse->dataResponse("Email Sent", null, "No Error", false);

                                        //automatically log user in after sending email
                                        $authenticationHelper->createAuthenticationSession($authenticationId);
                                        return;
                                    }else{
                                        $dataResponse->dataResponse(null, -1, "Product Not Found, user not registered. Contact Administrator", true);
                                        return;
                                    }

                                }else{
                                    $dataResponse->dataResponse(null, -1, "Unable to create Email", true);
                                    return;   
                                } //invalid Email
                            }else{
                                $dataResponse->dataResponse(null, -1, "Unable to create Email", true);
                                return;   
                            } //invalid Email
                        }else{
                            $dataResponse->dataResponse(null, -1, "Unable to create Entity", true);
                            return;   
                        }//invalid Entity
                    }else{
                        $dataResponse->dataResponse(null, -1, "Unable to create Entity", true);
                        return;   
                    }//invalid Entity
                }else{
                    $dataResponse->dataResponse(null, -1, "Unable to create Authentication", true);
                    return;   
                }
            }else{
                $dataResponse->dataResponse(null, -1, "User already exists", true);
                return;   
            }//user already exists
        }else{
            //displays the page
            $viewHelper = new cp_view_helper();
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/signUp.php', array());
            return; 
        }
    }

    public function success(){
        $viewHelper = new cp_view_helper();
        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/success.php', array());
        return;
    }

    public function loggedin(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");
        
        $viewHelper = new cp_view_helper();
        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/loggedIn.php', array());
        return;  
    }

    public function passwordOldCheck(){
        $userlogin = $_GET['userlogin'];
        $authenticationHelper = new cp_authentication_helper();
        $dataResponse = new cp_resData_helper();

        $userloginToLower = strtolower($userlogin);

        $authenticationDao = new cp_authentication_dao();
        $resAuthentication = $authenticationDao->getAuthentication(null, $userloginToLower);
        if ($resAuthentication['Error'] == false){
            if ($resAuthentication['TotalRowsAvailable'] > 0){
                $authentication = $resAuthentication['Data'][0];
                $authenticationId = $authentication->authenticationId;
                $authOldCheck = $authenticationHelper->checkOldAuthentication($authenticationId);
                if ($authOldCheck == true){
                    $dataResponse->dataResponse($authenticationId, null, null, false);
                }else{
                    $dataResponse->dataResponse($authOldCheck, null, null, false);
                }
            }else{
                $dataResponse->dataResponse(null, null, "Invalid Account", true);
                return;
            }
        }else{
            $dataResponse->dataResponse(null, null, "Invalid Account", true);
            return;
        }
    }

    public function passwordOld(){
        $userHelper = new cp_user_helper();
        $viewHelper = new cp_view_helper();
        if (isset($_GET['auth'])){
	    $OS = null;
            $authId = $_GET['auth'];
	    if (isset($_GET['OS'])){ $OS = $_GET['OS']; };
            $authenticationDao = new cp_authentication_dao();
            $resAuthentication = $authenticationDao->getAuthentication($authId);
            if ($resAuthentication['Error'] == false){
                if ($resAuthentication['TotalRowsAvailable'] > 0){
                    //check valid authentication
                    $authenticationHelper = new cp_authentication_helper();
                    $authOldCheck = $authenticationHelper->checkOldAuthentication($authId);
                    if ($authOldCheck == true){
                        $entityId = $userHelper->getCurrentEntityId();
                        if ($entityId != null){
                            header( 'Location:/account/changePassword');
                        }else{
                            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/passwordOld.php', array());
                            return;
                        }
                    }else{
                        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                                "message" => "Your password is up to date"
                            ));
                        return;
                    }
                }else{
                    echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                            "message" => "Invalid Account"));
                    return;
                }
            }else{
                echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                        "message" => "Invalid Account"));
                return;
            }
        }else{
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                    "message" => "Invalid Account"));
            return;
        }
    }

    public function settings(){
        //only users are allowed;
        $authorizationHelper = new cp_authorization_helper();
        $authorizationHelper->setUserAuthorization("/home");

        //render the page view
        $view = new cp_view_helper();
        echo $view->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/settings.php', array());
    }

    public function changePassword(){
        $dataResponse = new cp_resData_helper();
        $encryptionHelper = new cp_encryption_helper();
        $authenticationHelper= new cp_authentication_helper();
        $userHelper = new cp_user_helper();
        $entityId = $userHelper->getCurrentEntityId();

        $authenticationDao = new cp_authentication_dao();

        if (isset($_POST['json'])){
            $jsonPost = $_POST['json'];
            $changePassword = json_decode($jsonPost, true);
            $authenticationId = $changePassword['AuthenticationID'];
            $password = $changePassword['NewPassword'];
            $oldPassword = $changePassword['OldPassword'];
	    $OS = $changePassword['OS'];


            $resAuthentication = $authenticationDao->getAuthentication($authenticationId);
            if ($resAuthentication['Error'] == false){
                //get the authentication response
                if ($resAuthentication['TotalRowsAvailable'] > 0){
                    $authentication = $resAuthentication['Data'][0];
                    $oldHash = $authentication->hash;
                    $oldSalt = $authentication->salt;
                    $username = $authentication->authenticationStringLower;
                    if ($oldSalt != null || $oldSalt != ""){
                        //if we are using old security then we should just set the password straight
                        $changePasswordRes = $authenticationHelper->changePassword($authenticationId, $password);
                        if ($changePasswordRes == true){
                            //if user is not logged in, create a session and log user in
                            if ($entityId == null || $entityId == ""){
                                $resLogin = $authenticationHelper->authenticateUser($username, $password);
                            }
			    if($OS === "ios"){
				$dataResponse->dataResponse("ios", null, "Password changed", false);	
			    }else{
			        $dataResponse->dataResponse(null, null, "Password changed", false);
			    }
                            return;
                        }else{
                            $dataResponse->dataResponse(null, null, "Unable to change password", true);
                            return;
                        }
                    }else{
                        $checkValidity = $encryptionHelper->verify($oldPassword, $oldHash);
                        if ($checkValidity == true){
                            //change the password
                            $changePasswordRes = $authenticationHelper->changePassword($authenticationId, $password);
                            if ($changePasswordRes == true){
                                //if user is not logged in, create a session and log user in
                                if ($entityId == null || $entityId == ""){
                                    $resLogin = $authenticationHelper->authenticateUser($username, $password);
                                }
                                $dataResponse->dataResponse(null, null, "Password changed", false);
                                return;
                            }else{
                                $dataResponse->dataResponse(null, null, "Unable to change password", true);
                                return;
                            }
                        }else{
                            $dataResponse->dataResponse(null, null, "Current password is invalid", true);
                            return;
                        }
                    }

                }else{
                    $dataResponse->dataResponse(null, null, "User not found", true);
                    return;
                }
            }else{
                $dataResponse->dataResponse(null, null, "Invalid Request", true);
                return;
            }
        }
    }
    
    public function login(){
        $viewHelper = new cp_view_helper();
        if (isset($_POST['json'])){
            $userHelper = new cp_user_helper();
            $dataResponse = new cp_resData_helper();
            $entityId = $userHelper->getCurrentEntityId();

            $jsonPost = $_POST['json'];
            $newentity = json_decode($jsonPost, true);

            $username = $newentity['Username'];
            $password = $newentity['Password'];
            $authenticationHelper = new cp_authentication_helper();
            $resLogin = $authenticationHelper->authenticateUser($username, $password);
            if ($resLogin != false){
                $dataResponse->dataResponse($resLogin, null, "Authenticated", false);
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Credentials", true);
            }
            return;
        }else{
            $userHelper = new cp_user_helper();
            $entityId = $userHelper->getCurrentEntityId();
            if ($entityId != null){
                header( 'Location:/account/loggedin');
                return;
            }

            //displays the page
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/logIn.php', array());
            return; 
        }
    }
    
    public function logout(){
        $authentication = new cp_authentication_helper();
        $logoutRes = $authentication->destroyAuthentication();
        if ($logoutRes == true){
            header( 'Location:/');
        }else{
            header( 'Location:/devices');
        }
        return;
    }

    public function appLogout(){  
        $userHelper = new cp_user_helper();
        $dataResponse = new cp_resData_helper();
        
        $jsonPost = $_POST['json'];
        $newentity = json_decode($jsonPost, true);

        $entityId = $newentity['entityID'];
	$status = 'O';  

        if ($entityId != NULL){
            $entityDao = new cp_entity_dao();
           $entityDao->updateEntity(
                           $entityId
                           , null
                           , null
                           , null
                           , null
                           , $status
                           , null
                           , null
                           , null
                           , null
                           , null
                           , null
                           );
	     $dataResponse->dataResponse(null, null, "Updated", false);   
	}else{
	     $dataResponse->dataResponse(null, -1, "Failed", true);  
	}
	return;
        
    }

    public function appLogin(){  
        $viewHelper = new cp_view_helper();

        if (isset($_POST['json'])){
            $userHelper = new cp_user_helper();
            $dataResponse = new cp_resData_helper();
            $entityId = $userHelper->getCurrentEntityId();

            $jsonPost = $_POST['json'];
            $newentity = json_decode($jsonPost, true);

            $username = $newentity['Username'];
            $password = $newentity['Password'];
	    $OS = $newentity['OS'];
            $authenticationHelper = new cp_authentication_helper();


            $userloginToLower = strtolower($username);

            $authenticationDao = new cp_authentication_dao();
            $resAuthentication = $authenticationDao->getAuthentication(null, $userloginToLower);
            if ($resAuthentication['Error'] == false){
                if ($resAuthentication['TotalRowsAvailable'] > 0){
                    $authentication = $resAuthentication['Data'][0];
                    $authenticationId = $authentication->authenticationId;
                    $authOldCheck = $authenticationHelper->checkOldAuthentication($authenticationId);
                    if ($authOldCheck == true){
                        //$dataResponse->dataResponse($authenticationId, null, null, false);
			$redirectData = array('redirect' => '/account/passwordOld?auth=' . $authenticationId . "&OS=" . $OS);
			$dataResponse->dataResponse($redirectData, null, "redirecting", false);
			return;
                    }else{
                        //$dataResponse->dataResponse($authOldCheck, null, null, false);
		        $resLogin = $authenticationHelper->authenticateUser($username, $password);
		        if ($resLogin != false){
                            //get the entity ID
                            $entityDao = new cp_entity_dao();
                            $resGetEntity = $entityDao->getEntity(
                                null,
                              	$authenticationId
                            );
                            if ($resGetEntity['Error'] == false){
				$dataResponse->dataResponse($resGetEntity['Data'], $resGetEntity['ErrorCode'], "Found", $resGetEntity['Error'], $resGetEntity['TotalRowsAvailable']);
                            }else{
                                $dataResponse->dataResponse(null, null, "Entity not registered to any products", false);
                                return;
                            }
		        }else{
		            $dataResponse->dataResponse(null, -1, "Invalid Credentials", true);
		        }
		        return;
                    }
                }else{
                    $dataResponse->dataResponse(null, null, "Invalid Account", true);
                    return;
                }
            }else{
                $dataResponse->dataResponse(null, null, "Invalid Account", true);
                return;
            }
        }else{
            $userHelper = new cp_user_helper();
            $entityId = $userHelper->getCurrentEntityId();
            if ($entityId != null){
                header( 'Location:/account/loggedin');
                return;
            }

            //displays the page
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/logIn.php', array());
            return; 
        }
        
    }
    
    public function setpassword(){
        $authenticationDao = new cp_authentication_dao();
        $authId = $_GET['auth'];
        $resAuthentication = $authenticationDao->getAuthentication($authId);
        $viewHelper = new cp_view_helper();
        if ($resAuthentication['Error'] == false){
            //if there is no hash password, its not expired
            if ($resAuthentication['TotalRowsAvailable'] > 0){
                if ($resAuthentication["TotalRowsAvailable"] > 0){
                    $authentication = $resAuthentication["Data"][0];
                    if ($authentication->hash != null || $authentication->hash != ""){
                        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                                "message" => "Set password request has expired!"
                            ));
                        return;
                    }else{
                        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/setPassword.php', array());
                    }
                }else{
                    echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                            "message" => "Set password request has expired!"
                        ));
                    return;
                }
            }else{
                    echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                        "message" => "Invalid Account!"
                    ));
                    return;
            }
        }else{
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Error/invalid.php', array(
                "message" => "Invalid account!"
            ));
            return;
        }
    }
    public function createPassword(){
        $authenticationHelper = new cp_authentication_helper();
        $authenticationDao = new cp_authentication_dao();
        
        $utcHelper = new cp_UTCconvertor_helper();
        $dataResponse = new cp_resData_helper();
        
        $jsonPost = $_POST['json'];
        $postPassword = json_decode($jsonPost, true);
        
        $authId = $postPassword['AuthenticationID'];
        $newPassword = $postPassword['NewPassword'];
        
        $resAuthentication = $authenticationDao->getAuthentication($authId);
        if ($resAuthentication['Error'] == false){
            //if there is no hash password, its not expired
            if ($resAuthentication['TotalRowsAvailable'] > 0){
                if ($resAuthentication['Data'][0]->hash != null || $resAuthentication['Data'][0]->hash != ""){
                    $dataResponse->dataResponse(null, -1, "Invalid Password", true);  
                    return;
                }else{
                    if ($authId != null){
                        if ($newPassword != null){
                            $encryption = new cp_encryption_helper();
                            $newHash = $encryption->hash($newPassword);
                            $resAuthentication = $authenticationDao->getAuthentication($authId);
                            if ($resAuthentication['Error'] == false){
                                $authenticationDao->updateAuthentication(
                                    $authId //mandatory
                                    , null
                                    , null
                                    , $newHash
                                    , null
                                    , $utcHelper->getCurrentDateTime()
                                    , null  
                                    , $utcHelper->getCurrentDateTime()
                                    , $utcHelper->getCurrentDateTime()
                                    , null
                                    , null
                                    , 100
                                    );
                                //create product registration as a starter account
                                //get the alpha starter product
                                $productDao = new cp_product_dao();
                                $resProduct = $productDao->getProduct(
                                    null
                                    , null
                                    , null
                                    , null
                                    , 'EYEORCAS-STARTER'
                                );
                                if ($resProduct['Error'] == false && $resProduct["TotalRowsAvailable"] > 0){
                                    //get the entity ID
                                    $entityDao = new cp_entity_dao();
                                    $resGetEntity = $entityDao->getEntity(
                                        null,
                                        $authId
                                    );
                                    if ($resGetEntity['Error'] == false){
                                        $entityId = $resGetEntity["Data"][0]->entityId;
                                        $productRegistrationDao = new cp_product_registration_dao();
                                        $productId = $resProduct['Data'][0]->productId;
                                        $productRegistrationDao->createProductRegistration(
                                            'V'
                                            , null
                                            , $productId
                                            , $entityId
                                        );
                                        //automatically log user in
                                        $authSession = $authenticationHelper->createAuthenticationSession($authId);
                                        if ($authSession == true){
                                            $dataResponse->dataResponse(null, null, "Password Set", false);
                                        }else{
                                            $dataResponse->dataResponse(null, null, "Password Set, not logged in", false);
                                        }
                                        return;
                                    }else{
                                        $dataResponse->dataResponse(null, null, "Entity not registered to any products", false);
                                        return;
                                    }
                                }else{
                                    $dataResponse->dataResponse(null, -1, "Product Not Found, user not registered. Contact Administrator", true);
                                    return;
                                }
                            }else{
                                $dataResponse->dataResponse(null, -1, "Authentication Expired", true);
                                return;    
                            }
                        }else{
                            $dataResponse->dataResponse(null, -1, "Invalid Password", true);  
                            return;  
                        }
                    }else{
                        $dataResponse->dataResponse(null, -1, "Authentication Expired", true);  
                        return;  
                    }
                }
            }else{
                $dataResponse->dataResponse(null, -1, "Invalid Password", true);  
                return;
            }
        }
    }

    public function getEntity(){
        $userHelper = new cp_user_helper();
        $dataResponse = new cp_resData_helper();
        //$entityId = $userHelper->getCurrentEntityId();
        
        $jsonPost = $_POST['json'];
        $newentity = json_decode($jsonPost, true);

        $authID = $newentity['AuthID'];

        $entity = new cp_entity_dao();
        $resEntity = $entity->getEntity(null, $authID);
        if ($resEntity != false){
            $dataResponse->dataResponse($resEntity, null, "Found", false);   
        }else{
            $dataResponse->dataResponse(null, -1, "Not Found", true);   
        }
        return;
    }
    
    public function forgotPassword(){
        //displays the page
        $viewHelper = new cp_view_helper();
        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/Views/Account/forgotPassword.php', array());
        return; 
    }

    public function appSignup(){ 
        if (isset($_POST['json'])){

            $jsonPost = $_POST['json'];
            $newentity = json_decode($jsonPost, true);
            $dataResponse = new cp_resData_helper();
            $authenticationHelper = new cp_authentication_helper();
            $utcHelper = new cp_UTCconvertor_helper();

            $first_name = $newentity['GivenName'];
            $last_name = $newentity['FamilyName'];
            $email = $newentity['Email'];
            $password = $newentity['Password'];
            $status = 'U';
            $approved = true;
            $type = '1';

            $authenticationId = "";

            $encryption = new cp_encryption_helper();
            $hash = $encryption->hash($password);

            //check if authentication exists
            $checkUserExists = $authenticationHelper->checkAuthenticationUserExists(strtolower($email));
            if ($checkUserExists == false){
                $authenticationDao = new cp_authentication_dao();
                $emailLower = strtolower($email);
                $resAuthentication = $authenticationDao->createAuthentication(
                        $email
                        , $emailLower
                        , $hash
                        , NULL
                            );
                $authenticationId = $resAuthentication['Id'];
                if ($resAuthentication['Error'] == false){
                    //insert a new entity
                    $entityDao = new cp_entity_dao();
                    $nickName = $first_name . " " . $last_name;
                    $resEntity = $entityDao->createEntity(
                            $first_name
                            , $last_name
                            , $nickName
                            , $status
                            , $approved
                            , $type
                            , $authenticationId
                            , null
                            , null
                            );
                    if ($resEntity['Error'] == false){
                        $entityId = $resEntity['Id'];
                        if ($entityId != NULL){
                            //insert the email
                            $emailDao = new cp_email_dao();
                            $resEmail = $emailDao->createEmail(
                                    $email
                                    , $entityId
                                );
                            if ($resEmail['Error'] == false){
                                $emailId = $resEmail['Id'];
                                if ($emailId != NULL || $email != NULL){
                                    //update dao with the latest email
                                    $entityDao->updateEntity(
                                            $entityId
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , null
                                            , $emailId
                                            , null
                                            , $utcHelper->getCurrentDateTime()
                                            );


                                        $mail = new cp_mailSender_helper();
                                        $receiverEmail = $email;
                                        $receiverName = $first_name . " " . $last_name;

                                        $subject = "Welcome to EyeOrcas";
                                        $htmlBody = "Dear " . $first_name .",<br><br> Thank you for signing up with EyeOrcas<br> ";
                                        $htmlBody .= "<br>Thank you for signing up with us.<br>";
                                        $htmlBody .= "Your username will be " . $email . ".<br><br>";
                                        $htmlBody .= "Verify for your account from this link - ". "http://" . $_SERVER['HTTP_HOST'] . "/P2P/account/verifyAccount?auth=" . $authenticationId;
                                        $htmlBody .= "<br><br>Best Regards,<br>";
                                        $htmlBody .= "Eye Orcas";

                                        $mail->sendMail(
                                            $receiverName
                                            , $receiverEmail
                                            , true
                                            , $subject
                                            , $htmlBody
                                            , null
                                            );
                                        $dataResponse->dataResponse("Email Sent", null, "No Error", false);
                                        return;   
                                }else{
                                    $dataResponse->dataResponse(null, -1, "Unable to create Email", true);
                                    return;   
                                } //invalid Email
                            }else{
                                $dataResponse->dataResponse(null, -1, "Unable to create Email", true);
                                return;   
                            } //invalid Email
                        }else{
                            $dataResponse->dataResponse(null, -1, "Unable to create Entity", true);
                            return;   
                        }//invalid Entity
                    }else{
                        $dataResponse->dataResponse(null, -1, "Unable to create Entity", true);
                        return;   
                    }//invalid Entity
                }else{
                    $dataResponse->dataResponse(null, -1, "Unable to create Authentication", true);
                    return;   
                }
            }else{
                $dataResponse->dataResponse(null, -1, "User already exists", true);
                return;   
            }//user already exists
        }else{
            //displays the page
            $viewHelper = new cp_view_helper();
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/P2P/Views/Account/signUp.php', array());  
            return; 
        }
    }

    public function verifyAccount(){
        $authenticationDao = new cp_authentication_dao();
        $authId = $_GET['auth'];
        $resAuthentication = $authenticationDao->getAuthentication($authId);
        $viewHelper = new cp_view_helper();
	$status = "V";
        $approved = true;
        $utcHelper = new cp_UTCconvertor_helper();
	$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");  
	$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");  
	$blackberry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");  
	$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");  
        if ($resAuthentication['Error'] == false){
            //if there is no hash password, its not expired
            if ($resAuthentication['TotalRowsAvailable'] > 0){
                if ($resAuthentication["TotalRowsAvailable"] > 0){
                    $authentication = $resAuthentication["Data"][0];
                    if ($authentication->hash != null || $authentication->hash != ""){
			$entity = new cp_entity_dao();
			$email = $authentication->authenticationStringLower;
			$resEntity = $entity->getEntity(null, $authId);
			$entityId = $resEntity["Data"][0]->entityId;
                        $entity->updateEntity(
                                            $entityId
                                            , null
                                            , null
                                            , null
                                            , null
                                            , $status
                                            , $approved
                                            , null
                                            , null
                                            , null
                                            , null
                                            , $utcHelper->getCurrentDateTime()
                                            );

			if ($iphone || $android || $ipod || $blackberry)  
			{  
 				header('Location: eyeOrcas://');
			}else{
				header('Location:../../Activated.php?Email=' . $email);
			}  

                        return;
                    }else{
                        echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/P2P/Views/Error/invalid.php', array(
                        "message" => "Invalid Account!"
                    ));
                    }
                }else{
                    echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/P2P/Views/Error/invalid.php', array(
                        "message" => "Invalid Account!"
                    ));
                    return;
                }
            }else{
                    echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/P2P/Views/Error/invalid.php', array(
                        "message" => "Invalid Account!"
                    ));
                    return;
            }
        }else{
            echo $viewHelper->render($_SERVER['DOCUMENT_ROOT'] . '/P2P/Views/Error/invalid.php', array(
                "message" => "Invalid account!"
            ));
            return;
        }
    }

    public function resendActivationLink(){
        $authenticationDao = new cp_authentication_dao();
        $authId = $_GET['auth'];
        $resAuthentication = $authenticationDao->getAuthentication($authId);
            $dataResponse = new cp_resData_helper();
        if ($resAuthentication['Error'] == false){
            //if there is no hash password, its not expired
            if ($resAuthentication['TotalRowsAvailable'] > 0){
                if ($resAuthentication["TotalRowsAvailable"] > 0){
                    $authentication = $resAuthentication["Data"][0];
		    $entity = new cp_entity_dao();
		    $resEntity = $entity->getEntity(null, $authId);

		    $email = $authentication->authenticationStringLower;
		    $first_name = $resEntity["Data"][0]->firstName;
		    $last_name = $resEntity["Data"][0]->lastName;

		    $mail = new cp_mailSender_helper();
		    $receiverEmail = $email;
		    $receiverName = $first_name . " " . $last_name;

		    $subject = "Welcome to EyeOrcas";
		    $htmlBody = "Dear " . $first_name .",<br><br> Thank you for signing up with EyeOrcas<br> ";
		    $htmlBody .= "<br>Thank you for signing up with us.<br>";
		    $htmlBody .= "Your username will be " . $email . ".<br><br>";
		    $htmlBody .= "Verify for your account from this link - ". "http://" . $_SERVER['HTTP_HOST'] . "/P2P/account/verifyAccount?auth=" . $authId;
		    $htmlBody .= "<br><br>Best Regards,<br>";
                    $htmlBody .= "Eye Orcas";

                    $mail->sendMail(
                                            $receiverName
                                            , $receiverEmail
                                            , true
                                            , $subject
                                            , $htmlBody
                                            , null
                                            );
                    $dataResponse->dataResponse("Email Sent", null, "No Error", false);
                    return;   
		}
	    }
	}



    }


    
    public function retrievePassword(){
        
    }
    
}
?>
