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
$module_name = 'echo_Recipients';
$listViewDefs [$module_name] = 
array (
  'NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'PARENT_NAME' => 
  array (
    'type' => 'parent',
    'studio' => 'visible',
    'label' => 'LBL_FLEX_RELATE',
    'width' => '10%',
    'default' => true,
  ),
  'ECHO_AGREEMENTS_ECHO_RECIPIENTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => 'echo_agreements_echo_recipients',
    'label' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_AGREEMENTS_TITLE',
    'width' => '10%',
    'default' => true,
  ),
  'ROLE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_ROLE',
    'sortable' => false,
    'width' => '10%',
  ),
  'AGREEMENT_STATUS' => 
  array (
    'type' => 'varchar',
    'studio' => 
    array (
      'editview' => false,
      'quickcreate' => true,
      'wirelesseditview' => true,
      'searchview' => true,
      'detailview' => true,
      'listview' => true,
    ),
    'sortable' => true,
    'label' => 'LBL_AGREEMENT_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'AGREEMENT_DATE_SENT' => 
  array (
    'type' => 'date',
    'studio' => 
    array (
      'editview' => false,
      'quickcreate' => true,
      'wirelesseditview' => true,
      'searchview' => true,
      'detailview' => true,
      'listview' => true,
    ),
    'sortable' => true,
    'label' => 'LBL_AGREEMENT_DATE_SENT',
    'width' => '10%',
    'default' => true,
  ),
  'AGREEMENT_DATE_SIGNED' => 
  array (
    'type' => 'date',
    'studio' => 
    array (
      'editview' => false,
      'quickcreate' => true,
      'wirelesseditview' => true,
      'searchview' => true,
      'detailview' => true,
      'listview' => true,
    ),
    'sortable' => true,
    'label' => 'LBL_AGREEMENT_DATE_SIGNED',
    'width' => '10%',
    'default' => true,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => true,
  ),
  'TEAM_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_TEAM',
    'default' => true,
  ),
  'EMAIL_ADDRESS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_EMAIL_ADDRESS',
    'width' => '10%',
    'default' => false,
  ),
);
?>
