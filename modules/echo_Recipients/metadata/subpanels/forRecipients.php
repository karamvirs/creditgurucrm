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
// created: 2011-03-17 18:51:51
$subpanel_layout['list_fields'] = array (
  'echo_agreements_echo_recipients_name' => 
  array (
    'name'=>'echo_agreements_echo_recipients_name',
	'module' => 'echo_Recipients',
	'target_record_key' => 'ECHO_AGREE6A54EEMENTS_IDA',
	'target_module' => 'echo_Agreements',
	'widget_class' => 'SubPanelDetailViewLink',
	'vname' => 'LBL_LIST_NAME',
	'varname' => 'ECHO_AGREEMENTS_ECHO_RECIPIENTS_NAME',
	'width' => '20%',
	'alias' => 'agreement_name',
	'sort_by' => 'agreement_name',
  ),  
  'agreement_status' => 
  array(
	  'vname' => 'LBL_AGREEMENT_STATUS',
	  'width' => '20%',
	  'default' => true,
	  'sortable' => false,
  ),
  'agreement_date_sent' => 
  array(
	  'vname' => 'LBL_AGREEMENT_DATE_SENT',
	  'width' => '15%',
	  'default' => true,
	  'sortable' => false,
  ),
  'agreement_date_signed' => 
  array(
	  'vname' => 'LBL_AGREEMENT_DATE_SIGNED',
	  'width' => '15%',
	  'default' => true,
	  'sortable' => false,
  ),
  'created_by_name' => 
  array (
	'type' => 'relate',
	'link' => 'created_by_link',
	'vname' => 'LBL_CREATED',
	'width' => '15%',
	'default' => true,
  ),
  'date_entered' => 
	array (
	  'type' => 'datetime',
	  'vname' => 'LBL_DATE_ENTERED',
	  'width' => '15%',
	  'default' => true,
	),
);
?>
