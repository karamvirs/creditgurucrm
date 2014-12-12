<?php
$layout_defs["Documents"]["subpanel_setup"]["echo_agreements_documents"] = array (
  'order' => 100,
  'module' => 'echo_Agreements',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ECHO_AGREEMENTS_DOCUMENTS_FROM_ECHO_AGREEMENTS_TITLE',
  'get_subpanel_data' => 'echo_agreements_documents',
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
?>
