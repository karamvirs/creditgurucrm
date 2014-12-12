<?php
require_once('config.php');
if (isset($_POST["email"])) {

$key = 'FG$%T';


    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <info@creditguruinc.com>' . "\r\n";

    $subject = "Request of payment from Credit guru";
    
    $amount_cents = $_POST['amount'] * 100;
	$string = "a={$amount_cents}&id={$_POST[id]}&type={$_POST[module]}";

$encrypted = base64_encode($string."::trsdftfghggfbg"); 
    $message = "Hi, <br /> Please pay $ $_POST[amount] by visiting <a href='$sugar_config[site_url]/payment.php?u=$encrypted'>$sugar_config[site_url]/payment.php?a=$amount_cents&id=$_POST[id]&type=$_POST[module]</a>";
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
