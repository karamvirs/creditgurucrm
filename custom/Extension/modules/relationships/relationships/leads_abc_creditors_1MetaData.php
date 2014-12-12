<?php
// created: 2014-10-08 11:36:00
$dictionary["leads_abc_creditors_1"] = array (
  'true_relationship_type' => 'one-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_abc_creditors_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'abc_Creditors',
      'rhs_table' => 'abc_creditors',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_abc_creditors_1_c',
      'join_key_lhs' => 'leads_abc_creditors_1leads_ida',
      'join_key_rhs' => 'leads_abc_creditors_1abc_creditors_idb',
    ),
  ),
  'table' => 'leads_abc_creditors_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'leads_abc_creditors_1leads_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'leads_abc_creditors_1abc_creditors_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'leads_abc_creditors_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'leads_abc_creditors_1_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_abc_creditors_1leads_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'leads_abc_creditors_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_abc_creditors_1abc_creditors_idb',
      ),
    ),
  ),
);