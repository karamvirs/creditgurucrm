<?php

class CreditorsLogic {
 //  
	function creditors($bean, $event, $arguments){

		global $db;
		//echo "<pre>"; print_r($bean);
		 $ID=$bean->id;
		//echo $bean->status;
		//die("her");
	 	
	 	 $sql = "SELECT * FROM `abc_creditors_contacts_c` WHERE `abc_creditors_contactsabc_creditors_idb`='$ID'";
		$result = $db->query($sql);
		$row = $db->fetchByAssoc($result);
		
		$contact_id =  $row['abc_creditors_contactscontacts_ida'];
		
		$sql1 ="SELECT * FROM `email_addr_bean_rel` WHERE `bean_id`= '$contact_id'  AND `deleted` = 0";
		$result1 = $db->query($sql1);
		$row1 = $db->fetchByAssoc($result1);
		$email_id = $row1['email_address_id'];
		
		
		
		$sql2="SELECT * FROM `email_addresses` WHERE `id` ='$email_id' and  `deleted`='0'";
		$result2 = $db->query($sql2);
		$row2 = $db->fetchByAssoc($result2);
		 echo $email_address = $row2['email_address'];
			
		
		$sql3="SELECT * FROM `abc_creditors` WHERE `id`= '$ID'";
		$result3 = $db->query($sql3);
		$row3 = $db->fetchByAssoc($result3);
		$status = $row3['status'];
		if($status!=$bean->status){
			
			$to = $email_address;
			$subject = "Creditors Status";
			$message = "
			<html>
			<head>
			<title>Creditors Status</title>
			</head>
			<body>
			<p>Hi ".$bean->abc_creditors_contacts_name." ,<br /><br /> Your creditors status has been changed by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> for further details.<br />Creditor Name:".$bean->name."<br/> Status:".$bean->status."<br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@creditguruinc.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}	
			
		}else if( $row3['experian']!=$bean->experian){
		
		$to = $email_address;
			$subject = "Creditors Experian";
			$message = "
			<html>
			<head>
			<title>Creditors Experian</title>
			</head>
			<body>
			<p>Hi ".$bean->abc_creditors_contacts_name." ,<br /><br /> Your creditors experian has been changed by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> for further details.<br />Creditor Name:".$bean->name."<br/> Experian:".$bean->experian."<br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@creditguruinc.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}
		
		
		}else if( $row3['equifax']!=$bean->equifax){
		
		$to = $email_address;
			$subject = "Creditors Equifax";
			$message = "
			<html>
			<head>
			<title>Creditors Equifax</title>
			</head>
			<body>
			<p>Hi ".$bean->abc_creditors_contacts_name." ,<br /><br /> Your creditors equifax has been changed by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> for further details.<br />Creditor Name:".$bean->name."<br/> Experian:".$bean->equifax."<br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@creditguruinc.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}
		
		
		}else if( $row3['transunion']!=$bean->transunion){
		
		$to = $email_address;
			$subject = "Creditors Transunion";
			$message = "
			<html>
			<head>
			<title>Creditors Transunion</title>
			</head>
			<body>
			<p>Hi ".$bean->abc_creditors_contacts_name." ,<br /><br /> Your creditors Transunion has been changed by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> for further details.<br />Creditor Name:".$bean->name."<br/> Trans union:".$bean->transunion."<br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@creditguruinc.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}
		
		
		}
		
		
		
		
		
		
	}
	
}

?>
