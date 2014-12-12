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
$_object_name = 'echo_agreements';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '{$CANCEL_BUTTON}',
          ),
          4 => 
          array (
            'customCode' => '{$SEND_DOCUMENT}',
          ),
          5 => 
          array (
            'customCode' => '{$CHECK_STATUS}',
          ),
          6 => 
          array (
            'customCode' => '{$REMINDER_BUTTON}',
          ),
        ),
      ),
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/echo_Agreements/echoAgreements.js',
        ),
      ),
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
            'label' => 'LBL_DOC_NAME',
          ),
          1 => 
          array (
            'name' => 'status_id',
            'studio' => 'visible',
            'label' => 'LBL_DOC_STATUS',
            'customCode' => '{$STATUS}',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'signature_type',
            'studio' => 'visible',
            'label' => 'LBL_SIGNATURE_TYPE',
            'customCode' => '<div id="signature_type">{$SIGNATURE_TYPE}</div>',
          ),
          1 => 
          array (
            'name' => 'date_sent',
            'studio' => 
            array (
              'editview' => false,
              'quickcreate' => false,
              'wirelesseditview' => false,
            ),
            'label' => 'LBL_DATE_SENT',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'i_need_to_sign',
            'label' => 'LBL_I_NEED_TO_SIGN',
          ),
          1 => 
          array (
            'name' => 'date_signed',
            'studio' => 
            array (
              'editview' => false,
              'quickcreate' => false,
              'wirelesseditview' => false,
            ),
            'label' => 'LBL_DATE_SIGNED',
          ),
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
            'name' => 'uploadfile',
            'displayParams' => 
            array (
              'link' => 'uploadfile',
              'id' => 'id',
            ),
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
          1 => 
          array (
            'name' => 'echo_agreements_accounts_name',
            'label' => 'LBL_ECHO_AGREEMENTS_ACCOUNTS_FROM_ACCOUNTS_TITLE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'days_until_signing_deadline',
            'label' => 'LBL_DAYS_UNTIL_SIGNING_DEADLINE',
          ),
          1 => 
          array (
            'name' => 'echo_agreements_opportunities_name',
          ),
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
            'customCode' => '{$HOST_SIGNING_LINK}',
          ),
          1 => 
          array (
            'name' => 'document_language',
            'studio' => 'visible',
            'label' => 'LBL_DOCUMENT_LANGUAGE',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DOC_DESCRIPTION',
          ),
        ),
      ),
      'lbl_detailview_panel3' => 
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
      ),
      'lbl_detailview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          
        ),
      ),
    ),
  ),
);
?>
