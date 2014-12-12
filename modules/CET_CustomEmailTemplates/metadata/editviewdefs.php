<?php
$module_name = 'CET_CustomEmailTemplates';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'includes' => 
      array (
      	0 => 
      	array (
      		'file' => 'modules/CET_CustomEmailTemplates/js/tinymce/js/tinymce/tinymce.min.js',
      	),
      	1 => 
      	array (
      		'file' => 'modules/CET_CustomEmailTemplates/js/include-tinyjs.js',
      	),
      ),
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
          1 => '',
        ),
        1 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>
