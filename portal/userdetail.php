<?php
include('session.php');

$contact_result = mysql_query("select c.*, cc.* from contacts as c join contacts_cstm as cc  on c.id = cc.id_c where c.id='$login_session'", $connection);

$contact = mysql_fetch_array($contact_result);
//echo"<pre>";
//print_r($contact);
$sql12="SELECT * FROM `email_addr_bean_rel` WHERE `bean_id`= '$contact[id]' AND `deleted`='0' ";
				$res12 = mysql_query($sql12);
				$row12=mysql_fetch_array($res12);
				$emailid =$row12['email_address_id'];
				$sql13="SELECT * FROM `email_addresses` WHERE `id`= '".$emailid."' AND `deleted`='0' ";
				$res13 = mysql_query($sql13);
				$row13=mysql_fetch_array($res13);
				$adminemail =  $row13['email_address'];

?>
<html>
<head>
<title>Your Home Page </title>
 <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="http://cdn.datatables.net/1.10.3/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
		<!-- bootstrap wysihtml5 - text editor -->
		
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<script>
 function Checkpass(){
		var pass = document.getElementById("pass").value;
		var cpass = document.getElementById("cpass").value;
		if(pass=='' || cpass==''){
		alert("Please enter password");
		return false;
		}
		if(pass.length < 6) {
        alert("Error: Password must contain at least six characters!");
		
		return false;
		}
		if(pass!=cpass){
		alert("Please enter correct password");
		return false;
		
		}
 }

</script>
<style>.odd{background:#DCE6F7}</style>
</head>
 <body class="skin-blue">
 
  <header class="header">
            <a href="profile.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               SUGARCRM
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
               
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                  
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo "$contact[salutation] $contact[first_name] $contact[last_name]"; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                   <div class="pull-left">
                                        <a href="profile.php?action=changepwd" class="btn btn-default btn-flat">Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
		 <div class="wrapper row-offcanvas row-offcanvas-left">
		   <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                  
                   
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="profile.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
						<li class=" active">
                            <a href="userdetail.php">
                                <i class="fa fa-table"></i> <span>User Detail</span>
                            </a>
                        </li>
						<li class="<?php if($_GET['action']=='creditors'){ ?>active<?php } ?>">
                            <a href="profile.php?action=creditors">
                                <i class="fa fa-th"></i> <span>View Creditors</span>
                            </a>
                        </li>
						<li class=" <?php if($_GET['action']=='notes'){ ?>active<?php } ?>">
                            <a href="profile.php?action=notes">
                                <i class="fa fa-table"></i> <span>View Notes</span>
                            </a>
                        </li>
                       
                       
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
			<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
				<h2>User Detail</h2>
				 <table class="table table-hover" >
					<tr><td><b>First Name:</b></td><td><?php echo $contact['first_name'];?></td></tr>
					<tr><td><b>Last Name:</b></td><td><?php echo $contact['last_name'];?></td></tr>
					<tr><td><b>Email:</b></td><td><?php echo $adminemail;?></td></tr>
					<tr><td><b>Phone:</b></td><td><?php echo $contact['phone_home'];?></td></tr>
					<tr><td><b>Mobile:</b></td><td><?php echo $contact['phone_mobile'];?></td></tr>
					<tr><td><b>Fax:</b></td><td><?php echo $contact['phone_fax'];?></td></tr>
					<tr><td><b>City:</b></td><td><?php echo $contact['primary_address_city'];?></td></tr>
					<tr><td><b>State:</b></td><td><?php echo $contact['primary_address_state'];?></td></tr>
					<tr><td><b>Postalcode:</b></td><td><?php echo $contact['primary_address_postalcode'];?></td></tr>
					<tr><td><b>Country:</b></td><td><?php echo $contact['primary_address_country'];?></td></tr>
					
				 
				 
				 </table>
				 </aside> 
				
			  
        </div><!-- ./wrapper -->
		<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
       
        
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>


        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script src="http://cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
 <script>
  $(function() {
  
	
	$('#example').dataTable( {
        "pagingType": "full_numbers"
    } );
               
  });
  
 
  }
  </script>
  
</html>
