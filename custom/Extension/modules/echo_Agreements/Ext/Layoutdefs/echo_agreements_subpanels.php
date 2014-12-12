<?php
$layout_defs["echo_Agreements"]["subpanel_setup"]["echo_agreements_documents"] = array (
  'order' => 2,
  'module' => 'Documents',
  'subpanel_name' => 'forEchoSign',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_ECHO_AGREEMENTS_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'echo_agreements_documents',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelEchoSignQuickCreateDocument',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelEchoSignSelectDocumentButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
$layout_defs["echo_Agreements"]["subpanel_setup"]["echo_agreements_echo_events"] = array (
  'order' => 3,
  'module' => 'echo_Events',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'echo_timestamp',
  'title_key' => 'LBL_ECHO_AGREEMENTS_ECHO_EVENTS_FROM_ECHO_EVENTS_TITLE',
  'get_subpanel_data' => 'echo_agreements_echo_events',
  'top_buttons' => array (),
);
$layout_defs["echo_Agreements"]["subpanel_setup"]["echo_agreements_echo_recipients"] = array (
  'order' => 1,
  'module' => 'echo_Recipients',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'signing_order',
  'title_key' => 'LBL_ECHO_AGREEMENTS_ECHO_RECIPIENTS_FROM_ECHO_RECIPIENTS_TITLE',
  'get_subpanel_data' => 'echo_agreements_echo_recipients',
  'top_buttons' => array ( 0 => array ('widget_class' => 'SubPanelEchoSignAddRecipient') ),
);
?>
