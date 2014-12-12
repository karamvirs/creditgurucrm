<?php
$module_name = 'abc_Creditors';
$listViewDefs [$module_name] = 
array (
  'ACCOUNT_NO' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ACCOUNT_NO',
    'width' => '5%',
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '5%',
  ),
  'ABC_CREDITORS_CONTACTS_NAME' => 
  array (
    'type' => 'relate',
    'link' => true,
    'label' => 'LBL_CLIENT',
    'id' => 'ABC_CREDITORS_CONTACTSCONTACTS_IDA',
    'width' => '15%',
    'default' => true,
  ),
  'STANDING' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_STANDING',
    'width' => '5%',
  ),
  'BALANCE_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_BALANCE_C',
    'width' => '5%',
  ),
  'EXPERIAN' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_EXPERIAN',
    'width' => '5%',
  ),
  'EQUIFAX' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_EQUIFAX',
    'width' => '5%',
  ),
  'TRANSUNION' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TRANSUNION',
    'width' => '10%',
  ),
  'QUOTE_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_QUOTE',
    'width' => '10%',
  ),
  'ADDRESS' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS',
    'width' => '10%',
    'default' => false,
  ),
  'RESPONSIBILITY' => 
  array (
    'type' => 'enum',
    'default' => false,
    'studio' => 'visible',
    'label' => 'LBL_RESPONSIBILITY',
    'width' => '10%',
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '5%',
    'default' => false,
  ),
  'ADDRESS_ID' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ADDRESS_ID',
    'width' => '10%',
    'default' => false,
  ),
  'LAST_REPORTED_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_LAST_REPORTED_C',
    'width' => '5%',
  ),
  'RECORD_UNTIL_C' => 
  array (
    'type' => 'varchar',
    'default' => false,
    'label' => 'LBL_RECORD_UNTIL_C',
    'width' => '5%',
  ),
);
?>
