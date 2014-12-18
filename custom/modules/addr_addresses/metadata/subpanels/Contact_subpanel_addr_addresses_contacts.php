<?php
// created: 2014-12-15 11:58:23
$subpanel_layout['list_fields'] = array (
  'address' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_ADDRESS',
    'width' => '80%',
    'default' => true,
    'link' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => NULL,
    'target_record_key' => NULL,
  ),
  'address_task' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'vname' => 'LBL_ADDRESS_TASK',
    'width' => '10%',
  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'addr_addresses',
    'width' => '4%',
    'default' => true,
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'addr_addresses',
    'width' => '5%',
    'default' => true,
  ),
);