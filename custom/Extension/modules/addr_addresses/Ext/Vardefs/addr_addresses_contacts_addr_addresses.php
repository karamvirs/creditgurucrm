<?php
// created: 2014-12-15 10:16:44
$dictionary["addr_addresses"]["fields"]["addr_addresses_contacts"] = array (
  'name' => 'addr_addresses_contacts',
  'type' => 'link',
  'relationship' => 'addr_addresses_contacts',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_ADDR_ADDRESSES_CONTACTS_FROM_CONTACTS_TITLE',
  'id_name' => 'addr_addresses_contactscontacts_ida',
);
$dictionary["addr_addresses"]["fields"]["addr_addresses_contacts_name"] = array (
  'name' => 'addr_addresses_contacts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ADDR_ADDRESSES_CONTACTS_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'addr_addresses_contactscontacts_ida',
  'link' => 'addr_addresses_contacts',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["addr_addresses"]["fields"]["addr_addresses_contactscontacts_ida"] = array (
  'name' => 'addr_addresses_contactscontacts_ida',
  'type' => 'link',
  'relationship' => 'addr_addresses_contacts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ADDR_ADDRESSES_CONTACTS_FROM_ADDR_ADDRESSES_TITLE',
);
