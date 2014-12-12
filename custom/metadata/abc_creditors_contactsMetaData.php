<?php
// created: 2014-07-17 07:25:15
$dictionary["abc_creditors_contacts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'abc_creditors_contacts' => 
    array (
      'lhs_module' => 'Contacts',
      'lhs_table' => 'contacts',
      'lhs_key' => 'id',
      'rhs_module' => 'abc_Creditors',
      'rhs_table' => 'abc_creditors',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'abc_creditors_contacts_c',
      'join_key_lhs' => 'abc_creditors_contactscontacts_ida',
      'join_key_rhs' => 'abc_creditors_contactsabc_creditors_idb',
    ),
  ),
  'table' => 'abc_creditors_contacts_c',
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
      'name' => 'abc_creditors_contactscontacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'abc_creditors_contactsabc_creditors_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'abc_creditors_contactsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'abc_creditors_contacts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'abc_creditors_contactscontacts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'abc_creditors_contacts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'abc_creditors_contactsabc_creditors_idb',
      ),
    ),
  ),
);