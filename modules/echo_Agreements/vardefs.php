<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Professional Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-professional-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
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
$dictionary['echo_Agreements'] = array(
	'table'=>'echo_agreements',
	'audited'=>true,
	'fields'=>array (
  'signature_type' => 
  array (
    'required' => true,
    'name' => 'signature_type',
    'vname' => 'LBL_SIGNATURE_TYPE',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'echosign_signature_type_list',
    'studio' => 'visible',
    'dependency' => false,
     'default' => 'ESIGN',
  ),
  'signature_flow' => 
  array (
    'required' => false,
    'name' => 'signature_flow',
    'vname' => 'LBL_SIGNATURE_FLOW',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'echosign_signature_flow_list',
    'studio' => 'visible',
    'dependency' => 'equal($i_need_to_sign, true)',
  ),
  'security_protect_signature' => 
  array (
    'required' => false,
    'name' => 'security_protect_signature',
    'vname' => 'LBL_SECURITY_PROTECT_SIGNATURE',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'security_protect_open' => 
  array (
    'required' => false,
    'name' => 'security_protect_open',
    'vname' => 'LBL_SECURITY_PROTECT_OPEN',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'reminder_frequency' => 
  array (
    'required' => false,
    'name' => 'reminder_frequency',
    'vname' => 'LBL_REMINDER_FREQUENCY',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'echosign_reminder_frequency_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'days_until_signing_deadline' => 
  array (
    'required' => false,
    'name' => 'days_until_signing_deadline',
    'vname' => 'LBL_DAYS_UNTIL_SIGNING_DEADLINE',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '10',
    'size' => '20',
    'options' => 'echosign_days_till_signing',
  ),
  'document_language' => 
  array (
    'required' => false,
    'name' => 'document_language',
    'vname' => 'LBL_DOCUMENT_LANGUAGE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'en_US',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 100,
    'size' => '20',
    'options' => 'echosign_document_language_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'document_key' => 
  array (
    'required' => false,
    'name' => 'document_key',
    'vname' => 'LBL_DOCUMENT_KEY',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'studio' => array('editview' => false, 'quickcreate' => false, 'wirelesseditview' => false, 'searchview' => false, 'detailview' => false),
  ),
  'status_id' => 
  array (
    'name' => 'status_id',
    'vname' => 'LBL_DOC_STATUS',
    'type' => 'enum',
    'len' => 100,
    'options' => 'echosign_status_id_list',
    'reportable' => '',
    'required' => false,
    'massupdate' => 0,
    'default' => 'DRAFT',
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
    'dependency' => false,
    'studio' => array('editview' => false, 'quickcreate' => false, 'wirelesseditview' => false, 'searchview' => false, 'detailview' => false),
  ),
  'status' => 
  array (
    'name' => 'status',
    'vname' => 'LBL_DOC_STATUS',
    'type' => 'varchar',
    'Comment' => 'Document status for Meta-Data framework',
    'required' => false,
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'security_password' => 
  array (
    'required' => false,
    'name' => 'security_password',
    'vname' => 'LBL_SECURITY_PASSWORD',
    'type' => 'encrypt',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'dbType' => 'varchar',
    'dependency' => 'or(equal($security_protect_open, true), equal($security_protect_signature, true))',
    'studio' => array('searchview' => false),
  ),
  'security_password_confirm' => 
  array (
    'required' => false,
    'name' => 'security_password_confirm',
    'vname' => 'LBL_SECURITY_PASSWORD_CONFIRM',
    'type' => 'encrypt',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
    'dbType' => 'varchar',
    'dependency' => 'or(equal($security_protect_open, true), equal($security_protect_signature, true))',
    'studio' => array('searchview' => false),
  ),
  'host_signing_for_first_signer' => 
  array (
    'required' => false,
    'name' => 'host_signing_for_first_signer',
    'vname' => 'LBL_HOST_SIGNING_FOR_FIRST_SIGNER',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'i_need_to_sign' => 
  array (
    'required' => false,
    'name' => 'i_need_to_sign',
    'vname' => 'LBL_I_NEED_TO_SIGN',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
  'filename' => 
  array (
    'name' => 'filename',
    'vname' => 'LBL_FILENAME',
    'type' => 'varchar',
    'required' => true,
    'importable' => 'required',
    'len' => '255',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'size' => '20',
  ),
  'description' => 
  array (
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'comment' => 'Full text of the note',
    'default' => 'Please review and sign this document.',
    'rows' => '6',
    'cols' => '80',
    'required' => false,
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
  ),
  'date_sent' => 
  array (
    'required' => false,
    'name' => 'date_sent',
    'vname' => 'LBL_DATE_SENT',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'size' => '20',
    'studio' => array('editview' => false, 'quickcreate' => false, 'wirelesseditview' => false),
  ),
  'date_signed' => 
  array (
    'required' => false,
    'name' => 'date_signed',
    'vname' => 'LBL_DATE_SIGNED',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'size' => '20',
    'studio' => array('editview' => false, 'quickcreate' => false, 'wirelesseditview' => false),
  ),
  'send_document_interactively' => 
  array (
    'required' => false,
    'name' => 'send_document_interactively',
    'vname' => 'LBL_SEND_DOCUMENT_INTERACTIVELY',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => '255',
    'size' => '20',
  ),
),
	'relationships'=>array (
),
	'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('echo_Agreements','echo_Agreements', array('basic','assignable','file'));