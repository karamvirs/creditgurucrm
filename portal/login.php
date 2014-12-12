<?php
session_start();//starting session
$error=''; //variable to store error message
 if (isset($_POST['submit'])) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "User ID or Password is invalid"; 
    } else{   
        //Establishing Connection with Server by passing server_name, user_id and password as a parameter 
        require_once('../config.php');
        //print_r($sugar_config);
        $connection = mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']);

        //Selecting Database
        $db = mysql_select_db($sugar_config['dbconfig']['db_name'], $connection);
                                                                      
        // Define $username and $password 
        $username=$_POST['username']; 
        $password=$_POST['password']; 

        // To protect MySQL injection for Security purpose 
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
								
        //SQL query to fetch information of registerd users and finds user match.
        $query = mysql_query("select * from contacts_cstm where portal_password_c='$password' AND id_c IN (
        SELECT eabr.bean_id
        FROM email_addr_bean_rel eabr 
            JOIN email_addresses ea ON (ea.id = eabr.email_address_id)
        WHERE 
            eabr.bean_module = 'Contacts' 
            AND eabr.deleted = 0 
            AND ea.email_address = '$username'
    )", $connection);
        $rows = mysql_num_rows($query);

        if ($rows == 1) {
            $row = mysql_fetch_assoc($query);
            $login_session =$row['id_c'];
            $_SESSION['login_user']=$row['id_c'];//Initializing Session
            header("location: profile.php");//Redirecting to other page
        } else {
            $error = "User ID or Password is invalid"; 
        }

        //Closing Connection
        mysql_close($connection);                           
    }
}
?>
