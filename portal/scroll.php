<?php
include('session.php');

$ids = $_POST['id'];

$page = $_REQUEST['page'];
if($_POST['actionfunction']=='showData')
{
	$sql="SELECT * FROM pm_portalmessages as mesg INNER JOIN cases_pm_portalmessages_1_c as mesgcase ON mesgcase.cases_pm_portalmessages_1pm_portalmessages_idb=mesg.id INNER JOIN pm_portalmessages_cstm as replyuser ON replyuser.id_c=mesg.id  WHERE mesgcase.cases_pm_portalmessages_1cases_ida='".$ids."' ORDER BY  mesg.`date_entered` DESC LIMIT $page, 5 ";



	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){  

		$replyby =$row['reply_by_c'];
		$dateval = date('l jS \of F Y h:i:s A',strtotime($row['date_entered']));
		if($replyby=='Reply by Client')
			{ $vals = 'odd_div';}
		else{ $vals = 'even_div';}

		if($replyby=='Reply by Client')
			{ $idval = '<b>Message By You </b><br>'; }
		else{$idval = '<b> Reply By CRM Agent</b></br>';}



		echo "<div class='".$vals."'>".$idval."<b>POSTED ON:</b>".$dateval."<br>".$row['description']."</div>";



	}
	echo "<input type='hidden' name='this_time' id='this_time' value='".mysql_num_rows($result)."'>";
}elseif($_POST['actionfunction']=='cases'){

	$sql="SELECT * FROM  `cases` WHERE  `account_id` ='".$ids."' ORDER BY  `date_entered` DESC LIMIT $page,5";


	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){  

		$dateval = date('l jS \of F Y h:i:s A',strtotime($row['date_entered']));
		


		echo"<div class='odd_div'><b>POSTED ON:</b>".$dateval."<br><a href='details.php?a=messages&record=".$row['id']."'>".$row['description']."</a></div>";
	}
	echo "<input type='hidden' name='this_time' id='this_time' value='".mysql_num_rows($result)."'>";


}



?>