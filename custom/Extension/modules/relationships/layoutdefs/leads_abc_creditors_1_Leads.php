<?php
 // created: 2014-10-08 11:36:00
$layout_defs["Leads"]["subpanel_setup"]['leads_abc_creditors_1'] = array (
  'order' => 100,
  'module' => 'abc_Creditors',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_LEADS_ABC_CREDITORS_1_FROM_ABC_CREDITORS_TITLE',
  'get_subpanel_data' => 'leads_abc_creditors_1',
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
