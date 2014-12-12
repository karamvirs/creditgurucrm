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
$module_name = 'echo_Agreements';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
        'hidden' => 
        array (
        ),
      ),
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
      'javascript' => '
			<script type="text/javascript" src="include/javascript/popup_parent_helper.js"></script>
			<script type="text/javascript" src="modules/Documents/documents.js"></script>
			<script type="text/javascript" src="modules/echo_Agreements/echoAgreements.js"></script>
		',
      'useTabs' => false,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'document_name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'echo_agreements_accounts_name',
            'label' => 'LBL_ECHO_AGREEMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'signature_type',
            'studio' => 'visible',
            'label' => 'LBL_SIGNATURE_TYPE',
          ),
          1 => 
          array (
            'name' => 'echo_agreements_opportunities_name',
            'label' => 'LBL_ECHO_AGREEMENTS_OPPORTUNITIES_FROM_OPPORTUNITIES_TITLE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'i_need_to_sign',
            'label' => 'LBL_I_NEED_TO_SIGN',
          ),
          1 => '',
          
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'signature_flow',
            'studio' => 'visible',
            'label' => 'LBL_SIGNATURE_FLOW',
          ),
          1 => 
          array (
            'name' => 'document_language',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENT_LANGUAGE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'reminder_frequency',
            'studio' => 'visible',
            'label' => 'LBL_REMINDER_FREQUENCY',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'days_until_signing_deadline',
            'label' => 'LBL_DAYS_UNTIL_SIGNING_DEADLINE',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'send_document_interactively',
            'label' => 'LBL_SEND_DOCUMENT_INTERACTIVELY',
          ),
          1 => '',
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'host_signing_for_first_signer',
            'label' => 'LBL_HOST_SIGNING_FOR_FIRST_SIGNER',
          ),
          1 => '',
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'description',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'security_protect_signature',
            'label' => 'LBL_SECURITY_PROTECT_SIGNATURE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'security_protect_open',
            'label' => 'LBL_SECURITY_PROTECT_OPEN',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'security_password',
            'label' => 'LBL_SECURITY_PASSWORD',
            'customCode' => '<input type="password" tabindex="115" value="{$fields.security_password.value}" maxlength="30" size="30" id="security_password" name="security_password">',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'security_password_confirm',
            'label' => 'LBL_SECURITY_PASSWORD_CONFIRM',
            'customCode' => '<input type="password" tabindex="115" value="{$fields.security_password_confirm.value}" maxlength="30" size="30" id="security_password_confirm" name="security_password_confirm">&nbsp;&nbsp;<span id="passwords_match_icon" class="">&nbsp;&nbsp;&nbsp;</span>',
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
