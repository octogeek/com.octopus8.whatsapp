<?php

require_once 'whatsapp.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function whatsapp_civicrm_config(&$config) {
  _whatsapp_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function whatsapp_civicrm_xmlMenu(&$files) {
  _whatsapp_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function whatsapp_civicrm_install() {
  $groupID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionGroup','sms_provider_name','id','name');
  $params  = 
    array('option_group_id' => $groupID,
          'label' => 'Octopus8',
          'value' => 'com.octopus8.whatsapp',
          'name'  => 'whatsapp',
          'is_default' => 1,
          'is_active'  => 1,
          'version'    => 3,);
  require_once 'api/api.php';
  civicrm_api( 'option_value','create', $params );

  return _whatsapp_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function whatsapp_civicrm_uninstall() {
  $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue','whatsapp','id','name');
  if ($optionID)
    CRM_Core_BAO_OptionValue::del($optionID); 
  
  $filter    =  array('name'  => 'com.octopus8.whatsapp');
  $Providers =  CRM_SMS_BAO_Provider::getProviders(False, $filter, False);
  if ($Providers){
    foreach($Providers as $key => $value){
      CRM_SMS_BAO_Provider::del($value['id']);
    }
  }
  return _whatsapp_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function whatsapp_civicrm_enable() {
  $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue','whatsapp' ,'id','name');
  if ($optionID)
    CRM_Core_BAO_OptionValue::setIsActive($optionID, TRUE); 
  
  $filter    =  array('name' => 'com.octopus8.whatsapp');
  $Providers =  CRM_SMS_BAO_Provider::getProviders(False, $filter, False);
  if ($Providers){
    foreach($Providers as $key => $value){
      CRM_SMS_BAO_Provider::setIsActive($value['id'], TRUE); 
    }
  }
  return _whatsapp_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function whatsapp_civicrm_disable() {
  $optionID = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_OptionValue','whatsapp','id','name');
  if ($optionID)
    CRM_Core_BAO_OptionValue::setIsActive($optionID, FALSE);
  
  $filter    =  array('name' =>  'com.octopus8.whatsapp');
  $Providers =  CRM_SMS_BAO_Provider::getProviders(False, $filter, False);
  if ($Providers){
    foreach($Providers as $key => $value){
      CRM_SMS_BAO_Provider::setIsActive($value['id'], FALSE); 
    }
  }
  return _whatsapp_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function whatsapp_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _whatsapp_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function whatsapp_civicrm_managed(&$entities) {
  return _whatsapp_civix_civicrm_managed($entities);
}
