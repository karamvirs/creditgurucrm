<?php
// created: 2014-07-28 10:03:30
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => '20%',
    'default' => true,
  ),
  'account_no' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_ACCOUNT_NO',
    'width' => '10%',
    'default' => true,
  ),
  'status' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_STATUS',
    'width' => '10%',
  ),
  'standing' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_STANDING',
    'width' => '10%',
  ),
  'last_reported_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_LAST_REPORTED_C',
    'width' => '10%',
  ),
  'balance_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_BALANCE_C',
    'width' => '10%',
  ),
  'experian' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_EXPERIAN',
    'width' => '10%',
  ),
  'equifax' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_EQUIFAX',
    'width' => '10%',
  ),
  'transunion' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_TRANSUNION',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'abc_Creditors',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'abc_Creditors',
    'width' => '5%',
    'default' => true,
  ),
);