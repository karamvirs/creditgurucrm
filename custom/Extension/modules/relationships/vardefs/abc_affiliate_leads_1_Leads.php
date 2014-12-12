<?php
// created: 2014-07-24 07:21:36
$dictionary["Lead"]["fields"]["abc_affiliate_leads_1"] = array (
  'name' => 'abc_affiliate_leads_1',
  'type' => 'link',
  'relationship' => 'abc_affiliate_leads_1',
  'source' => 'non-db',
  'module' => 'abc_affiliate',
  'bean_name' => 'abc_affiliate',
  'vname' => 'LBL_ABC_AFFILIATE_LEADS_1_FROM_ABC_AFFILIATE_TITLE',
  'id_name' => 'abc_affiliate_leads_1abc_affiliate_ida',
);
$dictionary["Lead"]["fields"]["abc_affiliate_leads_1_name"] = array (
  'name' => 'abc_affiliate_leads_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ABC_AFFILIATE_LEADS_1_FROM_ABC_AFFILIATE_TITLE',
  'save' => true,
  'id_name' => 'abc_affiliate_leads_1abc_affiliate_ida',
  'link' => 'abc_affiliate_leads_1',
  'table' => 'abc_affiliate',
  'module' => 'abc_affiliate',
  'rname' => 'name',
);
$dictionary["Lead"]["fields"]["abc_affiliate_leads_1abc_affiliate_ida"] = array (
  'name' => 'abc_affiliate_leads_1abc_affiliate_ida',
  'type' => 'link',
  'relationship' => 'abc_affiliate_leads_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ABC_AFFILIATE_LEADS_1_FROM_LEADS_TITLE',
);
