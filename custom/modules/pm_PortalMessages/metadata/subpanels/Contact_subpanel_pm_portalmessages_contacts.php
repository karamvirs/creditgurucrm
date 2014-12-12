<?php
// created: 2014-12-04 10:57:37
$subpanel_layout['list_fields'] = array (
  'description' => 
  array (
    'type' => 'text',
    'link' => true,
    'vname' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '60%',
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => NULL,
    'target_record_key' => NULL,
  ),
  'reply_by_c' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'vname' => 'LBL_REPLY_BY',
    'width' => '10%',
  ),
  'date_modified' => 
  array (
    'vname' => 'LBL_DATE_MODIFIED',
    'width' => '10%',
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
  'remove_button' => 
  array (
    'vname' => 'LBL_REMOVE',
    'widget_class' => 'SubPanelRemoveButton',
    'module' => 'pm_PortalMessages',
    'width' => '5%',
    'default' => true,
  ),
);