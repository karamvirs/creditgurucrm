<?php
$dictionary['Lead']['fields']['echo_Recipients'] = array (
	'name' => 'echo_Recipients',
	'type' => 'link',
	'relationship' => 'echo_Recipients_leads_c',
	'module'=>'echo_Recipients',
	'bean_name'=>'echo_Recipients',
	'source'=>'non-db',
	'vname'=>'LBL_LEADS');
					 
					 
$dictionary['Lead']['relationships']['echo_Recipients_leads_c'] = array(
	'lhs_module'=> 'Leads',
	'lhs_table'=> 'leads',
	'lhs_key' => 'id',
	'rhs_module'=> 'echo_Recipients',
	'rhs_table'=> 'echo_recipients',
	'rhs_key' => 'parent_id',
	'relationship_type'=>'one-to-many');
?>