<?php
// created: 2014-12-04 11:40:53
$dictionary["pm_PortalMessages"]["fields"]["cases_pm_portalmessages_1"] = array (
  'name' => 'cases_pm_portalmessages_1',
  'type' => 'link',
  'relationship' => 'cases_pm_portalmessages_1',
  'source' => 'non-db',
  'module' => 'Cases',
  'bean_name' => 'Case',
  'vname' => 'LBL_CASES_PM_PORTALMESSAGES_1_FROM_CASES_TITLE',
  'id_name' => 'cases_pm_portalmessages_1cases_ida',
);
$dictionary["pm_PortalMessages"]["fields"]["cases_pm_portalmessages_1_name"] = array (
  'name' => 'cases_pm_portalmessages_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CASES_PM_PORTALMESSAGES_1_FROM_CASES_TITLE',
  'save' => true,
  'id_name' => 'cases_pm_portalmessages_1cases_ida',
  'link' => 'cases_pm_portalmessages_1',
  'table' => 'cases',
  'module' => 'Cases',
  'rname' => 'name',
);
$dictionary["pm_PortalMessages"]["fields"]["cases_pm_portalmessages_1cases_ida"] = array (
  'name' => 'cases_pm_portalmessages_1cases_ida',
  'type' => 'link',
  'relationship' => 'cases_pm_portalmessages_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CASES_PM_PORTALMESSAGES_1_FROM_PM_PORTALMESSAGES_TITLE',
);
