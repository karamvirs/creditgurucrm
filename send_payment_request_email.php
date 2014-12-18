<?php
ini_set('display_errors', 'off');
error_reporting(0);
if (!defined('sugarEntry'))
    define('sugarEntry', true);
include ('include/MVC/preDispatch.php');
$startTime = microtime(true);
require_once('include/entryPoint.php');


require_once('include/MVC/SugarApplication.php');
require_once('config.php');
global $db;
if (isset($_POST["email"])) {

		$client_id=$_POST['id'];
		$key = 'FG$%T';
		$amount_cents = $_POST['amount'] * 100;
		$string = "a={$amount_cents}&id={$_POST[id]}&type={$_POST[module]}";

	$encrypted = base64_encode($string."::trsdftfghggfbg"); 
	$link ="<a href='$sugar_config[site_url]/payment.php?u=$encrypted'>$sugar_config[site_url]/payment.php?a=$amount_cents&id=$_POST[id]&type=$_POST[module]</a>";
	 $sql = "SELECT * FROM contacts l JOIN contacts_cstm lc ON l.id = lc.id_c WHERE id = '$client_id'";
    $qry = $db->query($sql);
    $clientdata = $db->fetchByAssoc($qry);
	
	$sql = "SELECT * FROM cet_customemailtemplates as cet JOIN cet_customemailtemplates_cstm as cus ON cet.id=cus.id_c
		WHERE id = '" . $_POST['template'] . "'";
		$qry = $db->query($sql);
		$tmpl = $db->fetchByAssoc($qry);
		$html = html_entity_decode($tmpl['description']);
		$html ="<html><body>$html</body></html>";
		$html = str_replace('{{paid}}', $_POST['amount'], $html);
		$html = str_replace('{{link}}', $link, $html);
		$html = str_replace('{{first_name}}', $clientdata['first_name'], $html);
		$html = str_replace('{{last_name}}', $clientdata['last_name'], $html);
		$html = str_replace('{{quoted_amount}}', $clientdata['quoted_amount_c'], $html);
		$html = str_replace('{{paid_amount}}', $clientdata['paid_amount_c'], $html);
		$html = str_replace('{{balance_amount}}', $clientdata['balance_amount_c'], $html);

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <info@creditguruinc.com>' . "\r\n";

    $subject = "Request of payment from Credit guru";
    
   
    //$message = "Hi, <br /> Please pay $ $_POST[amount] by visiting <a href='$sugar_config[site_url]/payment.php?u=$encrypted'>$sugar_config[site_url]/payment.php?a=$amount_cents&id=$_POST[id]&type=$_POST[module]</a>";
	$message =$html;
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    if(mail("$_POST[email]",$subject,$message,$headers)){
        echo "Email sent";
    } else{
        echo "Failed to send email";
    }
        
}
?>
