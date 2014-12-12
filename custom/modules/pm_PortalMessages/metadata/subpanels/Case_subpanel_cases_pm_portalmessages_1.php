<?php
// created: 2014-12-06 09:12:34
$subpanel_layout['list_fields'] = array (
  'description' => 
  array (
    'type' => 'text',
    'link' => true, 
    'vname' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
      'widget_class' => 'SubPanelDetailViewLink',
  ), 
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '45%',
    'default' => true,

  ),
  'edit_button' => 
  array (
    'vname' => 'LBL_EDIT_BUTTON',
    'widget_class' => 'SubPanelEditButton',
    'module' => 'pm_PortalMessages',
    'width' => '4%',
    'default' => true,
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'vname' => 'LBL_CREATED',
    'id' => 'CREATED_BY',
    'width' => '10%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Users',
    'target_record_key' => 'created_by',
  ),
  'reply_by_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_REPLY_BY',
    'width' => '10%',
  ),
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'pm_PortalMessages',
    'width' => '5%',
    'default' => true,
  ),
);