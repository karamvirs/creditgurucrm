<?php
 // created: 2014-07-17 07:25:15
$layout_defs["Contacts"]["subpanel_setup"]['abc_creditors_contacts'] = array (
  'order' => 100,
  'module' => 'abc_Creditors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ABC_CREDITORS_CONTACTS_FROM_ABC_CREDITORS_TITLE',
  'get_subpanel_data' => 'abc_creditors_contacts',
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
