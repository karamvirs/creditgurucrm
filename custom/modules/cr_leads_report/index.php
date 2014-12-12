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
    $('#leads_results').DataTable({
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
<h2>Search leads</h2>
<form onkeydown="" action="" method="post" class="search_form" id="search_form" name="search_form">
  <table class="table" cellspacing="5"><tbody>
    <tr>
      <td>
        <input type="hidden" value="advanced_search" name="searchFormTab">
        <input type="hidden" value="cr_leads_report" name="module">
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
              <label for="status">Status</label>
        	  </td><td width="25%" nowrap="nowrap">
              <select name="status">
                <?php foreach($app_list_strings['lead_status_dom'] as $key=>$val){
                  echo "<option value='$key'>$val</option>";
                } ?>  
              </select>
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
  
  if(isset($_POST['status']) and $_POST['status'] != ''){
    $where .= " AND `l`.`status` = '$_POST[status]' "; 
  }

  if(isset($_POST['first_name']) and $_POST['first_name'] != ''){
    $where .= " AND `l`.`first_name` LIKE '%$_POST[first_name]%' "; 
  }
  
  if(isset($_POST['last_name']) and $_POST['last_name'] != ''){
    $where .= " AND `l`.`last_name` LIKE '%$_POST[last_name]%' "; 
  }
  
  if(isset($_POST['date_created_start']) and $_POST['date_created_start'] != ''){
    $where .= " AND `l`.`date_entered` >= '$_POST[date_created_start]' "; 
  }

  if(isset($_POST['date_created_end']) and $_POST['date_created_end'] != ''){
    $where .= " AND `l`.`date_entered` <= '$_POST[date_created_end] 23:59:59' "; 
  }

  $sql = "SELECT *
FROM `leads` AS `l`
JOIN `users_leads_1_c` AS `ul` ON `l`.`id` = `ul`.`users_leads_1leads_idb`
WHERE `users_leads_1users_ida` = '$current_user->id' AND `l`.`deleted` = 0 AND `ul`.`deleted` = 0 $where";

//  echo $sql;

  $result = $GLOBALS['db']->query($sql);

  if($result->num_rows == 0){
    echo "<h1>No results found</h1>";
  } else{
    echo "<br/><table class='table table-bordered table-striped table-hover' id='leads_results'><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone No</th><th>Status</th><th>Created at</th></thead><tbody>";
    $sr = 1;
    while($row = $GLOBALS['db']->fetchByAssoc($result) ){
      //Use $row['id'] to grab the id fields value
      //pr($row);
  $query = "SELECT email_addr_bean_rel . * , email_addresses . *  FROM email_addr_bean_rel INNER JOIN email_addresses ON email_addr_bean_rel.email_address_id = email_addresses.id WHERE email_addr_bean_rel.bean_id =  '$row[users_leads_1leads_idb]'";
$res = $GLOBALS['db']->query($query);
while($rest = $GLOBALS['db']->fetchByAssoc($res))
{
      echo "<tr><td>$sr</td><td>$row[salutation] $row[first_name] $row[last_name]</td><td>$rest[email_address]</td><td>$row[phone_mobile]</td><td>$row[status]</td><td>$row[date_entered]</td>";
	 
      $sr++;
	  }
    }
    
    echo "</tbody></table>";
  }
  
//}
?>
