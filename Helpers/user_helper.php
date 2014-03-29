<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

/*
 * A helper to get the information of the current user logged in to chilli panda
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/Helpers/session_helper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Model/Dao/entityDao.php';

class cp_user_helper{
    function getCurrentUserId(){
        $sessionHelper = new cp_session_helper();
        $userId = $sessionHelper->getSessionValue('AuthenticationId');
        return $userId;
    }

    function getCurrentEnterpriseId(){
        $sessionHelper = new cp_session_helper();
        $enterpriseId = $sessionHelper->getSessionValue('EnterpriseId');
        return $enterpriseId;
    }

    function getCurrentEnterpriseName(){
        $sessionHelper = new cp_session_helper();
        $enterpriseName = $sessionHelper->getSessionValue('EnterpriseName');
        return $enterpriseName;
    }

    function getTargetEnterpriseId(){
        $sessionHelper = new cp_session_helper();
        $targetEnterpriseId= $sessionHelper->getSessionValue('TargetEnterpriseId');
        return $targetEnterpriseId;
    }

    function getTargetEnterpriseName(){
        $sessionHelper = new cp_session_helper();
        $targetEnterpriseName = $sessionHelper->getSessionValue('TargetEnterpriseName');
        return $targetEnterpriseName;
    }

    function getCurrentEntityType(){
        $sessionHelper = new cp_session_helper();
        $entityType = $sessionHelper->getSessionValue('EntityType');
        return $entityType;
    }
    
    function getCurrentEntityId(){
        $sessionHelper = new cp_session_helper();
        $entityId = $sessionHelper->getSessionValue('EntityId');
        return $entityId;
    }
    
    function getCurrentAuthorizationLevel(){
        $sessionHelper = new cp_session_helper();
        $authorizationLevel = $sessionHelper->getSessionValue('AuthorizationLevel');
        return $authorizationLevel; 
    }
    
    function getCurrentEntityDetails(){
        $entityDao = new cp_entity_dao;
        $entityId = $this->getCurrentEntityId();
        
        if ($entityId == null){
            return null;
        }else{
            $entityRes = $entityDao->getEntity($entityId);
            if ($entityRes["Error"] == false){
                return $entityRes["Data"][0];
            }else{
                return null;
            }
        }
    }
    
    function getEntityDetails($entityId){
        $entityDao = new cp_entity_dao;
        if ($entityId == null){
            return null;
        }else{
            $entityRes = $entityDao->getEntity($entityId);
            if ($entityRes["Error"] == false){
                return $entityRes["Data"][0];
            }else{
                return null;
            }
        }
    }
}
 
?>

