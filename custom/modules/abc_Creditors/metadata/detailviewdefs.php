<?php
$module_name = 'abc_Creditors';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
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
          0 => 'description',
          1 => 
          array (
            'name' => 'quote_c',
            'label' => 'LBL_QUOTE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'last_reported_c',
            'label' => 'LBL_LAST_REPORTED_C',
          ),
          1 => 
          array (
            'name' => 'record_until_c',
            'label' => 'LBL_RECORD_UNTIL_C',
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
            'name' => 'balance_c',
            'label' => 'LBL_BALANCE_C',
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
            'name' => 'transunion',
            'studio' => 'visible',
            'label' => 'LBL_TRANSUNION',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'created_by_name',
            'label' => 'LBL_CREATED',
          ),
          1 => 'date_entered',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'modified_by_name',
            'label' => 'LBL_MODIFIED_NAME',
          ),
          1 => 'date_modified',
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'leads_abc_creditors_1_name',
            'label'=>'LBL_LEAD',
          ),
          1 => 
          array (
            'name' => 'abc_creditors_contacts_name',
            'label'=>'LBL_CLIENT',
          ),
        ),
      ),
    ),
  ),
);
?>
