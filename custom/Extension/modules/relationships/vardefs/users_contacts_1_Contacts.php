<?php
// created: 2014-08-22 11:38:50
$dictionary["Contact"]["fields"]["users_contacts_1"] = array (
  'name' => 'users_contacts_1',
  'type' => 'link',
  'relationship' => 'users_contacts_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_USERS_CONTACTS_1_FROM_USERS_TITLE',
  'id_name' => 'users_contacts_1users_ida',
);
$dictionary["Contact"]["fields"]["users_contacts_1_name"] = array (
  'name' => 'users_contacts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_USERS_CONTACTS_1_FROM_USERS_TITLE',
  'save' => true,
  'id_name' => 'users_contacts_1users_ida',
  'link' => 'users_contacts_1',
  'table' => 'users',
  'module' => 'Users',
  'rname' => 'name',
);
$dictionary["Contact"]["fields"]["users_contacts_1users_ida"] = array (
  'name' => 'users_contacts_1users_ida',
  'type' => 'link',
  'relationship' => 'users_contacts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_USERS_CONTACTS_1_FROM_CONTACTS_TITLE',
);
