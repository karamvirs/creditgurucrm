<?php
// created: 2014-12-15 10:16:44
$dictionary["addr_addresses_contacts"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'addr_addresses_contacts' => 
    array (
      'lhs_module' => 'Contacts',
      'lhs_table' => 'contacts',
      'lhs_key' => 'id',
      'rhs_module' => 'addr_addresses',
      'rhs_table' => 'addr_addresses',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'addr_addresses_contacts_c',
      'join_key_lhs' => 'addr_addresses_contactscontacts_ida',
      'join_key_rhs' => 'addr_addresses_contactsaddr_addresses_idb',
    ),
  ),
  'table' => 'addr_addresses_contacts_c',
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
      'name' => 'addr_addresses_contactscontacts_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'addr_addresses_contactsaddr_addresses_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'addr_addresses_contactsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'addr_addresses_contacts_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'addr_addresses_contactscontacts_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'addr_addresses_contacts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'addr_addresses_contactsaddr_addresses_idb',
      ),
    ),
  ),
);