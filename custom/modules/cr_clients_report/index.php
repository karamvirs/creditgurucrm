<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
  
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<!--script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script-->
<script type="text/javascript" language="Javascript">
$('#lastView').hide();
$('#shortcuts').hide();
$(document).ready( function () {
    $('#clients_results').DataTable({
      "pageLength": 200,
      "lengthMenu": [ [200, 500, 1000, -1], [200, 500, 1000, "All"] ]
    });
} );
</script>
<?php
function pr($ar){
  echo '<pre>';
  print_r($ar);
  echo '</pre>';
}
?>
<h2>Search clients</h2>
<form action="" method="post" class="search_form" id="search_form" name="search_form">
  <table class="table" cellspacing="5"><tbody>
    <tr>
      <td>
        <input type="hidden" value="advanced_search" name="searchFormTab">
        <input type="hidden" value="cr_clients_report" name="module">
        <input type="hidden" value="index" name="action"> 
        <input type="hidden" value="true" name="query">

        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>
          <tr>
            <td width="8.3333333333333%" nowrap="nowrap" scope="row">
              <label for="first_name">First Name</label>
            </td><td width="25%" nowrap="nowrap">
              <input type="text" accesskey="9" title="" value="" maxlength="100" size="30" id="first_name" name="first_name">
       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
              <label for="last_name">Last Name</label>
            </td><td width="25%" nowrap="nowrap">
              <input type="text" title="" value="" maxlength="100" size="30" id="last_name" name="last_name">
       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
              &nbsp;
        	  </td><td width="25%" nowrap="nowrap">
              &nbsp;
       	   	</td>
          </tr><tr>
            <td width="8.3333333333333%" nowrap="nowrap" scope="row">
              &nbsp;
            </td><td width="25%" nowrap="nowrap">
       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
            </td><td width="25%" nowrap="nowrap">
       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
        	  </td><td width="25%" nowrap="nowrap">
       	   	</td>
          </tr><tr>
            <td width="8.3333333333333%" nowrap="nowrap" scope="row">
              <label for="date_created_start">Start date</label>
            </td><td width="25%" nowrap="nowrap">
              <input type="text" accesskey="9" title="" value="" maxlength="100" size="30" id="date_created_start" name="date_created_start">
              <img border="0" src="themes/Sugar5/images/jscalendar.gif" alt="Enter Date" id="date_triggere" align="absmiddle" />

              <script type="text/javascript">

              Calendar.setup ({
              inputField : "date_created_start",
              daFormat : "%Y-%m-%d",
              button : "date_triggere",
              singleClick : true,
              dateStr : "",
              step : 1,
              weekNumbers:false
              });

              </script>

       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
              <label for="date_created_end">End date</label>
            </td><td width="25%" nowrap="nowrap">
              <input type="text" title="" value="" maxlength="100" size="30" id="date_created_end" name="date_created_end">
              <img border="0" src="themes/Sugar5/images/jscalendar.gif" alt="Enter Date" id="date_triggere_end" align="absmiddle" />

              <script type="text/javascript">

              Calendar.setup ({
              inputField : "date_created_end",
              daFormat : "%Y-%m-%d",
              button : "date_triggere_end",
              singleClick : true,
              dateStr : "",
              step : 1,
              weekNumbers:false
              });

              </script>
       	   	</td><td width="8.3333333333333%" nowrap="nowrap" scope="row">
              
        	  </td><td width="25%" nowrap="nowrap">
 
       	   	</td>
          </tr>
        </tbody></table>
      </td>
    </tr><tr>
      <td colspan="5">
        <input type="submit" id="search_form_submit_advanced" value="Search" name="button" class="button" title="Search" tabindex="2">&nbsp;

      </td><td class="help">
      </td>
    </tr>
  </tbody></table>
</form>
<?php
 	
//pr($_POST);
//if(isset($_POST['query']) and $_POST['query'] == 'true'){
  $where = " ";
  
  if(isset($_POST['first_name']) and $_POST['first_name'] != ''){
    $where .= " AND `c`.`first_name` LIKE '%$_POST[first_name]%' "; 
  }
  
  if(isset($_POST['last_name']) and $_POST['last_name'] != ''){
    $where .= " AND `c`.`last_name` LIKE '%$_POST[last_name]%' "; 
  }
  
  if(isset($_POST['date_created_start']) and $_POST['date_created_start'] != ''){
    $where .= " AND `c`.`date_entered` >= '$_POST[date_created_start]' "; 
  }

  if(isset($_POST['date_created_end']) and $_POST['date_created_end'] != ''){
    $where .= " AND `c`.`date_entered` <= '$_POST[date_created_end] 23:59:59' "; 
  }

  $sql = "SELECT *
FROM `contacts` AS `c`
JOIN `contacts_cstm` AS `cs` ON `c`.`id` = `cs`.`id_c`
JOIN  `users_contacts_1_c` AS `uc` ON `c`.`id` = `uc`.`users_contacts_1contacts_idb`
WHERE `users_contacts_1users_ida` = '$current_user->id' AND `c`.`deleted` = 0 AND `uc`.`deleted` = 0 $where";

  //echo $sql;

  $result = $GLOBALS['db']->query($sql);

  if($result->num_rows == 0){
    echo "<h1>No results found</h1>";
  } else{
    echo "<br/><table class='table table-bordered table-striped table-hover' id='clients_results'><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone No</th><th>Paid amount</th><th>Balance amount</th><th>Progress</th><th>Created at</th></thead><tbody>";
    $sr = 0;
    $total_paid_amount = 0;
    $total_balance_amount = 0;
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
      //Use $row['id'] to grab the id fields value
  //pr($row); 
 $query = "SELECT email_addr_bean_rel . * , email_addresses . *  FROM email_addr_bean_rel INNER JOIN email_addresses ON email_addr_bean_rel.email_address_id = email_addresses.id WHERE email_addr_bean_rel.bean_id =  '$row[users_contacts_1contacts_idb]'";
$res = $GLOBALS['db']->query($query);
while($rest = $GLOBALS['db']->fetchByAssoc($res))
{
//print_r($rest);
//echo $rest['email_address']."<br>";

	$sql = "SELECT
   count(*) as totalcount,
   (SELECT
      count(abc_creditors.experian)     
   FROM
      abc_creditors_contacts_c    
   JOIN
      abc_creditors      
         ON abc_creditors_contactsabc_creditors_idb = abc_creditors.id    
   JOIN
      abc_creditors_cstm      
         ON abc_creditors.id = abc_creditors_cstm.id_c    
   WHERE
      abc_creditors_contacts_c.abc_creditors_contactscontacts_ida = '$row[users_contacts_1contacts_idb]'    
      AND abc_creditors_contacts_c.deleted = 0    
      AND abc_creditors.deleted = 0    
      AND abc_creditors.experian = 'deleted'    )   as experian_deleted,
   (SELECT
      count(abc_creditors.equifax)     
   FROM
      abc_creditors_contacts_c    
   JOIN
      abc_creditors      
         ON abc_creditors_contactsabc_creditors_idb = abc_creditors.id    
   JOIN
      abc_creditors_cstm      
         ON abc_creditors.id = abc_creditors_cstm.id_c    
   WHERE
      abc_creditors_contacts_c.abc_creditors_contactscontacts_ida = '$row[users_contacts_1contacts_idb]'  
      AND abc_creditors_contacts_c.deleted = 0    
      AND abc_creditors.deleted = 0    
      AND abc_creditors.equifax = 'deleted'  ) as equifax_deleted,
   (SELECT
      count(abc_creditors.transunion)     
   FROM
      abc_creditors_contacts_c    
   JOIN
      abc_creditors      
         ON abc_creditors_contactsabc_creditors_idb = abc_creditors.id    
   JOIN
      abc_creditors_cstm      
         ON abc_creditors.id = abc_creditors_cstm.id_c    
   WHERE
      abc_creditors_contacts_c.abc_creditors_contactscontacts_ida = '$row[users_contacts_1contacts_idb]' 
      AND abc_creditors_contacts_c.deleted = 0    
      AND abc_creditors.deleted = 0    
      AND abc_creditors.transunion = 'deleted'  ) as transunion_deleted  
FROM
   abc_creditors_contacts_c  WHERE abc_creditors_contactscontacts_ida='$row[users_contacts_1contacts_idb]' ";
$results = $GLOBALS['db']->query($sql);
$restval = $GLOBALS['db']->fetchByAssoc($results);
			$num_rows=$restval['totalcount'];
          $experian = $restval['experian_deleted'];
		   $equifax=$restval['equifax_deleted'];
		   $transunion = $restval['transunion_deleted'];
		   $total = $experian+$equifax+$transunion;
		  $second_number = 3;
		  $sum_total = $num_rows * $second_number;
		  $finalval = $sum_total-$total;
	

      $sr++;
	  
      echo "<tr><td>$sr</td><td>$row[salutation] $row[first_name] $row[last_name]</td>
	  <td>$rest[email_address]</td><td>$row[phone_mobile]</td>
	  <td>$row[paid_amount_c]</td><td>$row[balance_amount_c]</td><td><b>No Of creditors:</b>$num_rows<br><b>Total:</b>$sum_total<br><b>Final Value:</b>$finalval</td><td>$row[date_entered]</td>";
      }
	  
      if(!empty($row['paid_amount_c'])) $total_paid_amount += $row['paid_amount_c'];
      if(!empty($row['balance_amount_c'])) $total_balance_amount += $row['balance_amount_c'];
    }
    
    echo "<tfoot><tr><th>&nbsp;</th><th>Total (all $sr records)</th><th></th><th></th><th>$total_paid_amount</th><th>$total_balance_amount</th><th>&nbsp</th></tfoot></tbody></table>";
  }
  
//}
?>
