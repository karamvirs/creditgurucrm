<?php
$dashletData['echo_RecipientsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'type' => 'assigned_user_name',
    'default' => 'Administrator',
  ),
);
$dashletData['echo_RecipientsDashlet']['columns'] = array (
  'parent_name' => 
  array (
    'type' => 'parent',
    'studio' => 'visible',
    'label' => 'LBL_FLEX_RELATE',
    'link' => true,
    'sortable' => false,
    'ACLTag' => 'PARENT',
    'dynamic_module' => 'PARENT_TYPE',
    'id' => 'PARENT_ID',
    'related_fields' => 
    array (
      0 => 'parent_id',
      1 => 'parent_type',
    ),
    'width' => '20%',
    'default' => true,
    'name' => 'parent_name',
  ),
  'echo_agreements_echo_recipients_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_AGREEMENTS_TITLE',
    'id' => 'ECHO_AGREE6A54EEMENTS_IDA',
    'width' => '20%',
    'default' => true,
    'name' => 'echo_agreements_echo_recipients_name',
  ),
  'agreement_status' => 
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
    'sortable' => false,
    'label' => 'LBL_AGREEMENT_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'name' => 
  array (
    'width' => '20%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => true,
    'name' => 'name',
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'agreement_date_signed' => 
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
    'sortable' => false,
    'label' => 'LBL_AGREEMENT_DATE_SIGNED',
    'width' => '15%',
    'default' => true,
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
