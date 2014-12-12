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
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
          1 => 
          array (
            'name' => 'agreement_status',
            'studio' => 
            array (
              'editview' => true,
              'quickcreate' => true,
              'wirelesseditview' => true,
              'searchview' => true,
              'detailview' => true,
              'listview' => true,
            ),
            'label' => 'LBL_AGREEMENT_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'echo_agreements_echo_recipients_name',
            'label' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_AGREEMENTS_TITLE',
          ),
          1 => 
          array (
            'name' => 'role',
            'studio' => 'visible',
            'label' => 'LBL_ROLE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'email_address',
            'label' => 'LBL_EMAIL_ADDRESS',
          ),
          1 => 
          array (
            'name' => 'signing_order',
            'studio' => 'visible',
            'label' => 'LBL_SIGNING_ORDER',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO_NAME',
          ),
         
        ),
      ),
    ),
  ),
);
?>
