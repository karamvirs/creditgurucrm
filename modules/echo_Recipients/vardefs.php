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
$dictionary['echo_Recipients'] = array(
	'table'=>'echo_recipients',
	'audited'=>true,
	'fields'=>array (
  'parent_name' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'parent_name',
    'vname' => 'LBL_FLEX_RELATE',
    'type' => 'parent',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 25,
    'size' => '20',
    'options' => 'echosign_parent_type_display',
    'studio' => 'visible',
    'type_name' => 'parent_type',
    'id_name' => 'parent_id',
    'parent_type' => 'record_type_display',
  ),
  'parent_type' => 
  array (
    'required' => false,
    'name' => 'parent_type',
    'vname' => 'LBL_PARENT_TYPE',
    'type' => 'parent_type',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 255,
    'size' => '20',
    'dbType' => 'varchar',
    'studio' => 'hidden',
  ),
  'parent_id' => 
  array (
    'required' => false,
    'name' => 'parent_id',
    'vname' => 'LBL_PARENT_ID',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => true,
    'calculated' => false,
    'len' => 36,
    'size' => '20',
  ),
  'email_address' => 
  array (
    'required' => false,
    'name' => 'email_address',
    'vname' => 'LBL_EMAIL_ADDRESS',
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
  ),
  'role' => 
  array (
    'required' => false,
    'name' => 'role',
    'vname' => 'LBL_ROLE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'Signer',
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
    'options' => 'echosign_role_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'signing_order' => 
  array (
    'required' => false,
    'name' => 'signing_order',
    'vname' => 'LBL_SIGNING_ORDER',
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
    'options' => 'echosign_signing_order_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'type' => 'name',
    'dbType' => 'varchar',
    'len' => '255',
    'unified_search' => true,
    'required' => true,
    'importable' => 'required',
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
  'agreement_status' => 
  array (
    'required' => false,
    'name' => 'agreement_status',
    'vname' => 'LBL_AGREEMENT_STATUS',
    'type' => 'varchar',
    'source' => 'non-db',
	'studio' => array('editview' => false, 'quickcreate' => true, 'wirelesseditview' => true, 'searchview' => true, 'detailview' => true, 'listview' => true),
	'sortable' => false,
	'reportable' => false,
  ),
  'agreement_date_signed' => 
  array (
    'required' => false,
    'name' => 'agreement_date_signed',
    'vname' => 'LBL_AGREEMENT_DATE_SIGNED',
    'type' => 'date',
    'source' => 'non-db',
	'studio' => array('editview' => false, 'quickcreate' => true, 'wirelesseditview' => true, 'searchview' => true, 'detailview' => true, 'listview' => true),
	'sortable' => false,
	'reportable' => false,
  ),
  'agreement_date_sent' => 
  array (
    'name' => 'agreement_date_sent',
    'vname' => 'LBL_AGREEMENT_DATE_SENT',
    'type' => 'date',
    'source' => 'non-db',
	'studio' => array('editview' => false, 'quickcreate' => true, 'wirelesseditview' => true, 'searchview' => true, 'detailview' => true, 'listview' => true),
	'sortable' => false,
	'reportable' => false,
  ),
),
	'relationships'=>array (
),
	'optimistic_locking'=>true,
);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('echo_Recipients','echo_Recipients', array('basic','assignable'));