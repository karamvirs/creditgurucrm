<?php

process_form();
  
function process_form(){
	require_once('modules/sc_StripePayments/Payments.php'); 
	$payments = new Payments();
	$data = $_POST;
	$record_id = $payments->make_charge($data);
	//die($record_id);
	header('Location: index.php?module=sc_StripePayments&action=DetailView&record='.$record_id);
	die();
}
?>