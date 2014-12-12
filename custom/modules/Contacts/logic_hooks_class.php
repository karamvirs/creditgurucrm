<?php

class ContactsLogic {
 //  global $db;
	function welcome($bean, $event, $arguments){
	//echo $contact_id=$bean->id;
//	echo $bean->fetched_row['portal_password_c'];
	//echo $bean->email1;

        if(empty($bean->portal_password_c)){
            $alphabet = "abcdefghijklmnopqrstuwxyz"; //ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789"
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $random_password = implode($pass); //turn the array into a string 
            
            $bean->portal_password_c = $random_password;      

			$to = $bean->email1;
			$subject = "Welcome to Credit guru";

			$message = "
			<html>
			<head>
			<title>Welcome to Credit Guru</title>
			</head>
			<body>
			<p>Hi ".$bean->salutation." ".$bean->first_name." ".$bean->last_name.",<br /><br /> Your account has been created by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> with following credentials.<br /> Email: ".$bean->email1." <br/>Password: ".$bean->portal_password_c."<br /><br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <creditguru@example.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}	
        }


		if($bean->fetched_row['portal_password_c'] != $bean->portal_password_c){
				//die("hii");
					/*$contact_id=$bean->id;
						$random_password=$bean->portal_password_c;*/
					//$sql = "UPDATE `contacts_cstm` SET `portal_password_c` = '$random_password' WHERE `contacts_cstm`.`id_c` = '$contact_id';";
					//$result = $db->query($sql);
					
					
			$to = $bean->email1;
			$subject = "Password Changed";

			$message = "
			<html>
			<head>
			<title>Password Changed</title>
			</head>
			<body>
			<p>Hi ".$bean->salutation." ".$bean->first_name." ".$bean->last_name.",<br /><br /> Your password has been changed by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> with following credentials.<br /> Email: ".$bean->email1." <br/>Password: ".$bean->portal_password_c."<br /><br/>Thanks, <br />Credit Guru</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <creditguru@example.com>' . "\r\n";
			//$headers .= 'Cc: myboss@example.com' . "\r\n";

			if (mail($to,$subject,$message,$headers)){
				//die('send');
			}	
					 
	

        }


	}

	
}

?>
