<?php
// created: 2014-10-13 08:28:36
$dictionary["Document"]["fields"]["abc_creditors_documents_1"] = array (
  'name' => 'abc_creditors_documents_1',
  'type' => 'link',
  'relationship' => 'abc_creditors_documents_1',
  'source' => 'non-db',
  'module' => 'abc_Creditors',
  'bean_name' => 'abc_Creditors',
  'vname' => 'LBL_ABC_CREDITORS_DOCUMENTS_1_FROM_ABC_CREDITORS_TITLE',
  'id_name' => 'abc_creditors_documents_1abc_creditors_ida',
);
$dictionary["Document"]["fields"]["abc_creditors_documents_1_name"] = array (
  'name' => 'abc_creditors_documents_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_ABC_CREDITORS_DOCUMENTS_1_FROM_ABC_CREDITORS_TITLE',
  'save' => true,
  'id_name' => 'abc_creditors_documents_1abc_creditors_ida',
  'link' => 'abc_creditors_documents_1',
  'table' => 'abc_creditors',
  'module' => 'abc_Creditors',
  'rname' => 'name',
);
$dictionary["Document"]["fields"]["abc_creditors_documents_1abc_creditors_ida"] = array (
  'name' => 'abc_creditors_documents_1abc_creditors_ida',
  'type' => 'link',
  'relationship' => 'abc_creditors_documents_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_ABC_CREDITORS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
);
