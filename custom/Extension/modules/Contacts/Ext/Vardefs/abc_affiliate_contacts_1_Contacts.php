<?php
// created: 2014-07-24 07:22:30
$dictionary["Contact"]["fields"]["abc_affiliate_contacts_1"] = array (
  'name' => 'abc_affiliate_contacts_1',
  'type' => 'link',
  'relationship' => 'abc_affiliate_contacts_1',
  'source' => 'non-db',
  'module' => 'abc_affiliate',
  'bean_name' => 'abc_affiliate',
  'vname' => 'LBL_ABC_AFFILIATE_CONTACTS_1_FROM_ABC_AFFILIATE_TITLE',
  'id_name' => 'abc_affiliate_contacts_1abc_affiliate_ida',
);
$dictionary["Contact"]["fields"]["abc_affiliate_contacts_1_name"] = array (
  'name' => 'abc_affiliate_contacts_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ABC_AFFILIATE_CONTACTS_1_FROM_ABC_AFFILIATE_TITLE',
  'save' => true,
  'id_name' => 'abc_affiliate_contacts_1abc_affiliate_ida',
  'link' => 'abc_affiliate_contacts_1',
  'table' => 'abc_affiliate',
  'module' => 'abc_affiliate',
  'rname' => 'name',
);
$dictionary["Contact"]["fields"]["abc_affiliate_contacts_1abc_affiliate_ida"] = array (
  'name' => 'abc_affiliate_contacts_1abc_affiliate_ida',
  'type' => 'link',
  'relationship' => 'abc_affiliate_contacts_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ABC_AFFILIATE_CONTACTS_1_FROM_CONTACTS_TITLE',
);
