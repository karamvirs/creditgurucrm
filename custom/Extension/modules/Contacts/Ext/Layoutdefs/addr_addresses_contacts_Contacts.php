<?php
 // created: 2014-12-15 10:16:44
$layout_defs["Contacts"]["subpanel_setup"]['addr_addresses_contacts'] = array (
  'order' => 100,
  'module' => 'addr_addresses',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ADDR_ADDRESSES_CONTACTS_FROM_ADDR_ADDRESSES_TITLE',
  'get_subpanel_data' => 'addr_addresses_contacts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
