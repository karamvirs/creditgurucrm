<?php
require_once('config.php'); 
$connection = mysql_connect($sugar_config['dbconfig']['db_host_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password']);

								//Selecting Database
								$db = mysql_select_db($sugar_config['dbconfig']['db_name'], $connection);
	$name=$_POST['filedvlaue'];
	$id=$_POST['id'];
	 $divid =$_POST['divid'];
		if($divid=="first_name"){
			 $sql = "UPDATE `contacts` SET `first_name`='$name' where id ='$id'";
		}elseif($divid=="last_name"){

			 $sql = "UPDATE `contacts` SET `last_name`='$name' where id ='$id'";
		}elseif($divid=="ssn_c"){

			 $sql = "UPDATE `contacts_cstm` SET `ssn_c`='$name' where id_c ='$id'";
		}elseif($divid=="point_of_contact_c"){
			 $sql = "UPDATE `contacts_cstm` SET `point_of_contact_c`='$name' where id_c ='$id'";
		}elseif($divid=="instructions_c"){
			 $sql = "UPDATE `contacts_cstm` SET `instructions_c`='$name' where id_c ='$id'";
		}elseif($divid=="quoted_amount_c"){  
			 $sql = "UPDATE `contacts_cstm` SET `quoted_amount_c`='$name' where id_c ='$id'";
		
		}elseif($divid=="paid_amount_c"){
			 $sql = "UPDATE `contacts_cstm` SET `paid_amount_c`='$name' where id_c ='$id'";
		}elseif($divid=="equifax_id_c"){
		
			 $sql = "UPDATE `contacts_cstm` SET `equifax_id_c`='$name' where id_c ='$id'";
		}elseif($divid=="experian_id_c"){
		
			 $sql = "UPDATE `contacts_cstm` SET `experian_id_c`='$name' where id_c ='$id'";
		}elseif($divid=="trans_union_id_c"){
			 $sql = "UPDATE `contacts_cstm` SET `trans_union_id_c`='$name' where id_c ='$id'";
		}elseif($divid=="trans_union_username_c"){
		
			 $sql = "UPDATE `contacts_cstm` SET `trans_union_username_c`='$name' where id_c ='$id'";
		}elseif($divid=="trans_union_password_c"){
			  $sql = "UPDATE `contacts_cstm` SET `trans_union_password_c`='$name' where id_c ='$id'";
		}
$result = mysql_query($sql);
if($result){

echo $divid.",".$name;

}

?>