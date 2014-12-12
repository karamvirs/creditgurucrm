<?php
/*************************************************************************
*
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2012 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/
$module_name = 'echo_Events';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'echo_agreements_echo_events_name' => 
      array (
        'type' => 'relate',
        'link' => 'echo_agreements_echo_events',
        'label' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_AGREEMENTS_TITLE',
        'width' => '10%',
        'default' => true,
        'name' => 'echo_agreements_echo_events_name',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'echo_agreements_echo_events_name' => 
      array (
        'type' => 'relate',
        'link' => 'echo_agreements_echo_events',
        'label' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_AGREEMENTS_TITLE',
        'width' => '10%',
        'default' => true,
        'name' => 'echo_agreements_echo_events_name',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
