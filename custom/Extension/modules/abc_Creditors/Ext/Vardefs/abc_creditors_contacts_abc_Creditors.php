<?php
// created: 2014-07-17 07:25:15
$dictionary["abc_Creditors"]["fields"]["abc_creditors_contacts"] = array (
  'name' => 'abc_creditors_contacts',
  'type' => 'link',
  'relationship' => 'abc_creditors_contacts',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_ABC_CREDITORS_CONTACTS_FROM_CONTACTS_TITLE',
  'id_name' => 'abc_creditors_contactscontacts_ida',
);
$dictionary["abc_Creditors"]["fields"]["abc_creditors_contacts_name"] = array (
  'name' => 'abc_creditors_contacts_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ABC_CREDITORS_CONTACTS_FROM_CONTACTS_TITLE',
  'save' => true,
  'id_name' => 'abc_creditors_contactscontacts_ida',
  'link' => 'abc_creditors_contacts',
  'table' => 'contacts',
  'module' => 'Contacts',
  'rname' => 'name',
  'db_concat_fields' => 
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
);
$dictionary["abc_Creditors"]["fields"]["abc_creditors_contactscontacts_ida"] = array (
  'name' => 'abc_creditors_contactscontacts_ida',
  'type' => 'link',
  'relationship' => 'abc_creditors_contacts',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ABC_CREDITORS_CONTACTS_FROM_ABC_CREDITORS_TITLE',
);
