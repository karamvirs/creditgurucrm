<?php
require_once('config.php'); 
$connection = mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']);

								//Selecting Database
								$db = mysql_select_db($sugar_config['dbconfig']['db_name'], $connection);
			$id = $_POST['catid'];
			
		$sql1 ="SELECT * FROM `email_addr_bean_rel` WHERE `bean_id`= '$id'  AND `deleted` = 0";
		$result1 = mysql_query($sql1);
		$row1 = mysql_fetch_array($result1);
		$email_id = $row1['email_address_id'];
		
		
		
		$sql2="SELECT * FROM `email_addresses` WHERE `id` ='$email_id' and  `deleted`='0'";
		$result2 =mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		 $email_address = $row2['email_address'];

		$alphabet = "abcdefghijklmnopqrstuwxyz"; //ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789"
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $random_password = implode($pass); //turn the array into a string 
			$sql="SELECT * FROM `contacts` WHERE `id`= '$id' AND deleted='0'";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			
            
            $pass = $random_password;      

			$to = $email_address;
			$subject = "Welcome to Credit guru";

			$message = "
			<html>
			<head>
			<title>Welcome to Credit Guru</title>
			</head>
			<body>
			<p>Hi ".$row['salutation']." ".$row['first_name']." ".$row['last_name'].",<br /><br /> Your account has been created by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> with following credentials.<br /> Email: ".$email_address." <br/>Password: ".$pass."<br /><br/>Thanks, <br />Credit Guru</p>
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
			
					$sql = "UPDATE `contacts_cstm` SET `portal_password_c` = '$pass' WHERE `contacts_cstm`.`id_c` = '$id';";
					$resultss =mysql_query($sql);
				if($resultss){
					echo"Mail send";
				}
			}	

?>