<?php
$module_name = 'abc_Creditors';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'account_no',
            'label' => 'LBL_ACCOUNT_NO',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'responsibility',
            'studio' => 'visible',
            'label' => 'LBL_RESPONSIBILITY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'address_id',
            'label' => 'LBL_ADDRESS_ID',
          ),
          1 => 
          array (
            'name' => 'address',
            'label' => 'LBL_ADDRESS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'comment' => 'Full text of the note',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array (
            'name' => 'transunion',
            'studio' => 'visible',
            'label' => 'LBL_TRANSUNION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'last_reported',
            'label' => 'LBL_LAST_REPORTED',
          ),
          1 => 
          array (
            'name' => 'record_until',
            'label' => 'LBL_RECORD_UNTIL',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'standing',
            'studio' => 'visible',
            'label' => 'LBL_STANDING',
          ),
          1 => 
          array (
            'name' => 'balance',
            'label' => 'LBL_BALANCE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'experian',
            'studio' => 'visible',
            'label' => 'LBL_EXPERIAN',
          ),
          1 => 
          array (
            'name' => 'equifax',
            'studio' => 'visible',
            'label' => 'LBL_EQUIFAX',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'abc_creditors_contacts_name',
            'label' => 'LBL_CLIENT',
          ),
          1 => 
          array (
            'name' => 'leads_abc_creditors_1_name',
            'label' => 'LBL_LEAD',
          ),
        ),
      ),
    ),
  ),
);
?>
