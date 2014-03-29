<?php
/*
 * Copyright Chilli Panda
 * Created on 05-03-2013
 * Created by Shi Wei Eamon
 */

/*
 * A helper on authentication
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/webConfig.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/authenticationDao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/enterpriseDao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Helpers/session_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Helpers/encryption_helper.php';

class cp_authentication_helper{
    //check if the authentication is old or new. If authentication is new, there wont be any salt stored. If its old, there will be a stored salt
    public function checkOldAuthentication($authenticationId){
        $authenticationDao = new cp_authentication_dao();
        $authenticationRes = $authenticationDao->getAuthentication($authenticationId);
        if ($authenticationRes['Error'] == false){
            if ($authenticationRes['TotalRowsAvailable'] > 0){
                $authentication = $authenticationRes['Data'][0];
                $authenticationSalt = $authentication->salt;
                if ($authenticationSalt != null || $authenticationSalt != "" ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function changePassword($authenticationId, $newPassword){
        $authenticationDao = new cp_authentication_dao();
        $encryption = new cp_encryption_helper();
        $utcHelper = new cp_UTCconvertor_helper();

        $newHash = $encryption->hash($newPassword);
        $updateAuthenticationRes = $authenticationDao->updateAuthentication(
            $authenticationId
            , null
            , null
            , $newHash
            , "" //remove the salt
            , null
            , null
            , $utcHelper->getCurrentDateTime()
            , $utcHelper->getCurrentDateTime()
            , null
            , null
            , null
        );
        if ($updateAuthenticationRes['Error'] == false){
            return true; //updated
        }else{
            return false;
        }
    }

    public function createAuthenticationSession($authenticationId){
        $sessionHelper = new cp_session_helper();
        $utcHelper = new cp_UTCconvertor_helper();
        $authenticationDao = new cp_authentication_dao();
        $entityDao = new cp_entity_dao();
        $enterpriseDao = new cp_enterprise_dao();
       
        //get the authentication response
        $authenticationRes = $authenticationDao->getAuthentication($authenticationId);
        if ($authenticationRes['Error'] == false){
            if ($authenticationRes['TotalRowsAvailable'] > 0){
            	$authentication = $authenticationRes['Data'][0];
                $authenticationStringLower = $authentication->authenticationStringLower;
                $authorizationLevel = $authentication->authorizationLevel;
                //update the authentication table with the current login timing
                $updateLoginRes = $authenticationDao->updateAuthentication(
                                $authenticationId
                                , null
                                , null
                                , null
                                , null
                                , $utcHelper->getCurrentDateTime()
                                , null
                                , null
                                , $utcHelper->getCurrentDateTime()
                                , null
                                , null
                                , null
                                );

                if ($updateLoginRes['Error'] == false){
                    $sessionHelper->startNewSession();
                    $sessionHelper->addSessionValue('AuthenticationId', $authenticationId);
                    $sessionHelper->addSessionValue('AuthenticationStringLower', $authenticationStringLower);
                    $sessionHelper->addSessionValue('AuthorizationLevel', $authorizationLevel);
                    $entityRes = $entityDao->getEntity(null, $authenticationId);
                    if ($entityRes['TotalRowsAvailable'] > 0){
                        $entity= $entityRes['Data'][0];
                        $entityId = $entity->entityId;
                        $entityType = $entity->type;
                        $sessionHelper->addSessionValue('EntityId', $entityId);
                        $sessionHelper->addSessionValue('EntityType', $entityType);

                        $webConfig = new webConfig();
                        $webConfig->enterpriseConfig();
                        $enterpriseId = $webConfig->enterpriseId;
                        $enterpriseName = $webConfig->enterpriseName;

                        $sessionHelper->addSessionValue('EnterpriseId', $enterpriseId);
                        $sessionHelper->addSessionValue('EnterpriseName', $enterpriseName);
                        $sessionHelper->addSessionValue('TargetEnterpriseId', $enterpriseId);
                        $sessionHelper->addSessionValue('TargetEnterpriseName', $enterpriseName);
                    }else{
                        return false;
                    }//unable to add entity to session
                }else{
                    return false;
                }//unable to add add user login
            }else{
                return false;
            }//unable to add authentication to session
        }else{
            return false;
        }//unable to add authentication to session
    }
    
    public function authenticateUser($identificationString, $password){
        $authenticationHash = NULL;
        $authenticationId = NULL;
        $encryption = new cp_encryption_helper();
        
        $authenticationDao = new cp_authentication_dao();
        $authenticationStringToLower = strtolower($identificationString);
        //get the authentication
        $authenticationRes = $authenticationDao->getAuthentication(
                null
                , $authenticationStringToLower
                );
        
        if ($authenticationRes != NULL){
            if($authenticationRes['Data']){
                $authentication = $authenticationRes['Data'][0];
                $authenticationHash = $authentication->hash;
                $authenticationId = $authentication->authenticationId;
            }
        }
        if($authenticationHash != NULL){
            $authenticated = $encryption->verify($password, $authenticationHash);
            if ($authenticated == true){
                //create new session
                $authenticationSession = $this->createAuthenticationSession($authenticationId);
            }
            return $authenticated;
        }else{
            //user not found
            return false;
        }
    }
    
    /**
     * mainly used for logging out
     */
    public function destroyAuthentication(){
        $sessionHelper = new cp_session_helper();
        $utcHelper = new cp_UTCconvertor_helper();

        //get the authenticationId
        $authenticationId = $sessionHelper->getSessionValue('AuthenticationId');
        if ($authenticationId != null || $authenticationId != false){
            //update the authentication table with the log out timings
            $authenticationDao = new cp_authentication_dao();
            $authenticationDao->updateAuthentication(
                    $authenticationId 
                    , null
                    , null
                    , null
                    , null
                    , null
                    , $utcHelper->getCurrentDateTime()
                    , null
                    , $utcHelper->getCurrentDateTime()
                    , null
                    , null
                    , null
                    );
            $sessionHelper->destroySession();
            return true; //logged out
        }else{
            return false; //not logged out
        }
    }
    
    /**
     * Mainly for checking if there is already a user in the database
     */
    public function checkAuthenticationUserExists($authenticationStringToLower){
        $authenticationDao = new cp_authentication_dao;
        $authenticationRes = $authenticationDao->getAuthentication(null, $authenticationStringToLower);
        
        if ($authenticationRes['Error'] == false){
            if ($authenticationRes['TotalRowsAvailable'] > 0){
                //user exists
                return true;
            }else{
                return false;
            }
        }
    }

    public function newAuthentication($identificationString, $password, $authType, $enterpriseId){
        $encryption = new cp_encryption_helper();
        $newHash = $encryption->hash($password);
        
        $authorizationController = new cp_Authentication_Controller();
        $authenticationString = $identificationString;
        $authenticationHash = $newHash;
        $authenticationType = $authType;
        $authenticationStatus = true;
        $enterpriseId = $enterpriseId;
        
        $authorizationController->addAuthentication(
                $authenticationString
                , $authenticationHash
                , null
                , $authenticationType
                , $authenticationStatus
                , $enterpriseId
                );
        return;
    }
}
?>
