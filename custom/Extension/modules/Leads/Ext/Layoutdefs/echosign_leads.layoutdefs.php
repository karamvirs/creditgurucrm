<?php
$layout_defs['Leads']['subpanel_setup']['echo_recipients'] = array(
	'order' => 1,
	'module' => 'echo_Recipients',
	'subpanel_name' => 'forRecipients',
	'sort_order' => 'asc',
	'sort_by' => 'id',
	'get_subpanel_data' => 'echo_Recipients',
	'add_subpanel_data' => 'parent_id',
	'title_key' => 'EchoSign Agreements',
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopButtonEchoSignNewAgreement'),
	),
);
?>