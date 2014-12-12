<?php
// created: 2014-10-08 11:36:00
$dictionary["abc_Creditors"]["fields"]["leads_abc_creditors_1"] = array (
  'name' => 'leads_abc_creditors_1',
  'type' => 'link',
  'relationship' => 'leads_abc_creditors_1',
  'source' => 'non-db',
  'module' => 'Leads',
  'bean_name' => 'Lead',
  'vname' => 'LBL_LEADS_ABC_CREDITORS_1_FROM_LEADS_TITLE',
  'id_name' => 'leads_abc_creditors_1leads_ida',
);
$dictionary["abc_Creditors"]["fields"]["leads_abc_creditors_1_name"] = array (
  'name' => 'leads_abc_creditors_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_LEADS_ABC_CREDITORS_1_FROM_LEADS_TITLE',
  'save' => true,
  'id_name' => 'leads_abc_creditors_1leads_ida',
  'link' => 'leads_abc_creditors_1',
  'table' => 'leads',
  'module' => 'Leads',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["abc_Creditors"]["fields"]["leads_abc_creditors_1leads_ida"] = array (
  'name' => 'leads_abc_creditors_1leads_ida',
  'type' => 'link',
  'relationship' => 'leads_abc_creditors_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_LEADS_ABC_CREDITORS_1_FROM_ABC_CREDITORS_TITLE',
);
