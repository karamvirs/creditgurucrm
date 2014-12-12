<?php
 // created: 2014-07-24 07:21:36
$layout_defs["abc_affiliate"]["subpanel_setup"]['abc_affiliate_leads_1'] = array (
  'order' => 100,
  'module' => 'Leads',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ABC_AFFILIATE_LEADS_1_FROM_LEADS_TITLE',
  'get_subpanel_data' => 'abc_affiliate_leads_1',
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
