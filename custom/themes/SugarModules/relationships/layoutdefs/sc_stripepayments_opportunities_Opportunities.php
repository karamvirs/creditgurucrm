<?php
 // created: 2013-01-20 19:26:38
$layout_defs["Opportunities"]["subpanel_setup"]['sc_stripepayments_opportunities'] = array (
  'order' => 100,
  'module' => 'sc_StripePayments',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_SC_STRIPEPAYMENTS_OPPORTUNITIES_FROM_SC_STRIPEPAYMENTS_TITLE',
  'get_subpanel_data' => 'sc_stripepayments_opportunities',
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
