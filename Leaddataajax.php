<?php
//require_once('config.php'); 
//$connection = mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']);

								//Selecting Database
								//$db = mysql_select_db($sugar_config['dbconfig']['db_name'], $connection);
			 $email = $_POST['email'];
			
		
			$to = $email;
			$subject = "LEAD INFORMATION";

			$message = "
			<html>
			<head>
			<title>Information of lead</title>
			</head>
			<body>
			<p>Hi <br>Lead information <br /><br/>Thanks, <br />Credit Guru</p>
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
			
					echo"Mail sent";
			}	

?>