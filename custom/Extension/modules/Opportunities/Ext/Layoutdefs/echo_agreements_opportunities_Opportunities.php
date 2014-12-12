<?php
 // created: 2012-04-17 16:23:59
$layout_defs["Opportunities"]["subpanel_setup"]['echo_agreements_opportunities'] = array (
  'order' => 100,
  'module' => 'echo_Agreements',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ECHO_AGREEMENTS_OPPORTUNITIES_FROM_ECHO_AGREEMENTS_TITLE',
  'get_subpanel_data' => 'echo_agreements_opportunities',
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
