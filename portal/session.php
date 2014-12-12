<?php
//Establishing Connection with Server by passing server_name, user_id and password as a parameter 
require_once('../config.php');
//print_r($sugar_config);
$connection = mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']);

								//Selecting Database
								$db = mysql_select_db($sugar_config['dbconfig']['db_name'], $connection);
                            
session_start();// Starting Session

//Storing session
$user_check=$_SESSION['login_user'];

//SQL query to fetch complete information of user   
//$ses_sql=mysql_query("select username from login where username='$user_check'", $connection);
$ses_sql = mysql_query("select id_c from contacts_cstm where id_c='$user_check'", $connection);

$row = mysql_fetch_assoc($ses_sql);

$login_session =$row['id_c'];

if(!isset($login_session)){

//Closing Connection
mysql_close($connection);
header('Location: index.php');//Redirecting to home page 
}
?>
