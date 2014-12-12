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
$dashletData['echo_EventsDashlet']['searchFields'] = array (
  'name' => 
  array (
    'default' => '',
  ),
  'echo_agreements_echo_events_name' => 
  array (
    'default' => '',
  ),
  'echo_timestamp' => 
  array (
    'default' => '',
  ),
  'date_entered' => 
  array (
    'default' => '',
  ),
);
$dashletData['echo_EventsDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'echo_agreements_echo_events_name' => 
  array (
    'type' => 'relate',
    'link' => 'echo_agreements_echo_events',
    'label' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_AGREEMENTS_TITLE',
    'width' => '20%',
    'default' => true,
  ),
  'echo_timestamp' => 
  array (
    'type' => 'datetimecombo',
    'label' => 'LBL_ECHO_TIMESTAMP',
    'width' => '10%',
    'default' => true,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
  
);
