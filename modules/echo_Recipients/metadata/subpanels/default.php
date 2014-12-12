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
$module_name='echo_Recipients';
$subpanel_layout = array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'echo_Recipients',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
   	'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelRecipientParentLink',
    'width' => '30%',
    'default' => true,
  ),
  'role' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_ROLE',
    'sortable' => true,
    'width' => '20%',
  ),
  'signing_order' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'vname' => 'LBL_SIGNING_ORDER',
    'width' => '10%',
    'default' => true,
  ),
  'email_address' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_EMAIL_ADDRESS',
    'width' => '30%',
    'default' => true,
  ),
 
  'remove_button' => 
  array (
    'widget_class' => 'SubPanelRemoveButtonForEchoSign',
    'module' => 'echo_Recipients',
    'width' => '5%',
    'default' => true,
  ),
   
	),
);