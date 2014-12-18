<?php
ini_set('display_errors', 'off');
error_reporting(0);
if (!defined('sugarEntry'))
    define('sugarEntry', true);
include ('include/MVC/preDispatch.php');
$startTime = microtime(true);
require_once('include/entryPoint.php');

		$ex_id=$_POST['id'];

		$sql = "SELECT * FROM abc_creditors WHERE id = '$ex_id'";
		$res = $db->query($sql);
		$row = $db->fetchByAssoc($res);

	 $qry = "UPDATE  abc_creditors_cstm SET experian_old_c = '".$row['experian']."', equifax_old_c = '".$row['equifax']."', transunion_old_c = '".$row['transunoin']."' , view_status_c = 0 WHERE  id_c = '$ex_id'";

			$data = $db->query($qry);
    if($data){
    	echo"done";
    }
?>