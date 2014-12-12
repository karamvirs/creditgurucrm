<?php
include('session.php');

$contact_result = mysql_query("select c.*, cc.* from contacts as c join contacts_cstm as cc  on c.id = cc.id_c where c.id='$login_session'", $connection);

$contact = mysql_fetch_array($contact_result);
$unique_id=strtolower(md5(uniqid(rand(), true)));


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
	<!-- bootstrap wysihtml5 - text editor -->
	<link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.8.2.js"></script>

	<style>.odd{background:#DCE6F7}</style>
	<style>.odd{background:#DCE6F7} 
		.odd_div{background: #DCE6F7;
			padding: 10px;
			border-radius: 10px;
			margin: 10px auto;
			width: 96%}
			.even_div {
				text-align: right;
				border: 1px solid #ccc;
				padding: 10px;
				border-radius: 11px;
				margin: 10px auto;
				width: 96%
			}
			#loading {

				left: 50%;
				position: fixed;
				top: 50%;
			}
		</style>
		<script type="text/javascript">


			$(function(){
				$( "#createcase" ).click(function() {
					$( ".mesgclass" ).toggle("slow");
				});
				$("#mesgreply").submit(function(){
					
					var topic_des = $('#topic_des').val();
					if(topic_des.length == 0){
						$('#error_both').css('display','block');
						return false;
					}
				}); 
				$('#load_more').click(function(){
				var scroll_top = $(this).scrollTop();
				var height = $('#demoajax').height();
				var count = $(".nextpage").val();
				var id =$(".ids").val();
				var isload = $('#demoajax').find('.isload').val();
				if($('#next_load').val()=='true'){


					$('#loading').show();
					$.ajax({
						url:"scroll.php",
						type:"POST",
						async: false,
						data:"actionfunction=showData&page="+count+"&id="+id,
						success: function(response){
							if(response){
								var $response=$(response);
								this_time = $response.filter('#this_time').val();
								if(this_time < 5 || this_time==0){
									$('#next_load').val('false');
									$('#load_more').val('no result');
								}

								$('#demoajax').append(response);
								var  finalcount=parseInt(count)+parseInt(5);
								$(".nextpage").val(finalcount);
							}else{
								$("body").css("overflow", "hidden");

							}
							
							$('#loading').hide();
						}
					});

				}	
			});
});

</script>
</head>
<body class="skin-blue">

	<input type="hidden" name="next_load" id='next_load' value="true">

	<header class="header">
		<a href="index.html" class="logo">
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
					 <li>
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
					<li class=" <?php if($_GET['action']=='cases'){ ?>active<?php } ?>">
						<a href="profile.php?action=cases">
							<i class="fa fa-table"></i> <span>Send Message</span>
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

			<!-- Main content -->

			<?php $ids= $_GET['record']; 
			$action= $_GET['a']; 
			if($action=="cre"){
				$sql="SELECT * FROM `abc_creditors` WHERE `id` = '$ids'";
				$result = mysql_query($sql);
				echo'<table border="1" cellpadding="5" width="500" style="margin: 30px;">';
				while($row=mysql_fetch_array($result)){
					echo"<tr class='odd'><td><b>Creditor Name</b></td><td>".$row['name']."</td></tr>
					<tr class='even'><td><b>Account#</b></td><td>".$row['account_no']."</td></tr>
					<tr class='odd'><td><b>Status</b></td><td>".$row['status']."</td></tr>
					<tr class='even'><td><b>Standing</b></td><td>".$row['standing']."</td></tr>
					<tr class='odd'><td><b>Last Reported</b></td><td>".$row['last_reported_c']."</td></tr>
					<tr class='even'><td><b>Blance</b></td><td>".$row['balance_c']."</td></tr>
					<tr class='odd'><td><b>AddressID</b></td><td>".$row['address_id']."</td></tr>
					<tr class='even'><td><b>Address</b></td><td>".$row['address']."</td></tr>
					<tr class='odd'><td><b>Description</b></td><td>".$row['description']."</td></tr>
					<tr class='even'><td><b>Experian</b></td><td>".$row['experian']."</td></tr>
					<tr class='odd'><td><b>Equifax</b></td><td>".$row['equifax']."</td></tr>
					<tr class='even'><td><b>Trans union</b></td><td>".$row['transunion']."</td></tr>";
					



				}
				
				echo'</table>';
				
			}else
			if($action=="messages"){

				if(isset($_REQUEST['sendmesg'])){

					$sendmesg = $_REQUEST['sendmesg_text'];
					$sql="INSERT INTO `pm_portalmessages` VALUES ('$unique_id', 'NULL', NOW(), NOW(), '1', '1', '$sendmesg', '0', '')";
					mysql_query($sql);
					$sql2="INSERT INTO `pm_portalmessages_cstm` VALUES ('$unique_id', 'Reply by Client')";
					mysql_query($sql2);
					function guidfinal(){
						if (function_exists('com_create_guid')){
							return com_create_guid();
						}else{
                                        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
                                        $charid = strtolower(md5(uniqid(rand(), true)));
                                        $hyphen = chr(45);// "-"
                                        $uuid = chr(123)// 
                                        .substr($charid, 0, 8).$hyphen
                                        .substr($charid, 8, 4).$hyphen
                                        .substr($charid,12, 4).$hyphen
                                        .substr($charid,16, 4).$hyphen
                                        .substr($charid,20,12)
                                        .chr(125);//
                                        return trim($uuid, '{}');
                                    }
                                }
                                $un_id=guidfinal();
                                $sql1="INSERT INTO `cases_pm_portalmessages_1_c` VALUES('$un_id', NOW(), '0', '$ids', '$unique_id') ";
                                mysql_query($sql1);
						 }

                            ?>
                            <img id="loading" src="712.GIF" style="display: none;">
                              <button id="createcase" style="float: right; background: none repeat scroll 0px 0px rgb(60, 141, 188); border: medium none; padding: 6px 20px; color: rgb(255, 255, 255); margin-right: 30px; margin-top: 6px;">Reply</button>
                            <div class="mesgclass" style="margin: 0px auto; width: 95%; overflow:hidden;display:none">
                            <h4 style='display:none;color:red' id='error_both'>Please Fill Message</h4>
                            	<form action="" method="post" id="mesgreply">
                            		Message:<textarea id="topic_des" name='sendmesg_text' style="width: 100%; height: 23%;margin-bottom: 14px;margin-top:15px;"></textarea><br>
                            		<input type="submit" name="sendmesg" value="SEND" style="float: right; background: #3c8dbc;border: 0px;color: #fff; padding: 5px 20px;">
                            	</form>
                            </div>
                            <div id="demoajax">
                            	<?php

                              $sql="SELECT * FROM  `cases` WHERE  `id` ='".$ids."' ORDER BY  `date_entered` DESC";
       							$query=mysql_query($sql);
       							$data = mysql_fetch_array($query);
       							echo "<div style='border: 1px solid rgb(204, 204, 204); margin: 4% auto 0px; border-radius: 5px; padding: 10px; width: 96%;'><b>Discussion Topic:&nbsp;".$data['name']."</b><br>".$data['description']."</div>";


                            	$sql="SELECT * FROM pm_portalmessages as mesg INNER JOIN cases_pm_portalmessages_1_c as mesgcase ON mesgcase.cases_pm_portalmessages_1pm_portalmessages_idb=mesg.id INNER JOIN pm_portalmessages_cstm as replyuser ON replyuser.id_c=mesg.id  WHERE mesgcase.cases_pm_portalmessages_1cases_ida='".$ids."' ORDER BY  mesg.`date_entered` DESC LIMIT 0 , 5";



                            	$result = mysql_query($sql);
                            	while($row=mysql_fetch_array($result)){   $replyby =$row['reply_by_c'];?>
                            	<div class="<?php if($replyby=='Reply by Client'){ echo'odd_div'; }else{echo'even_div'; } ?>">
                            		<?php   
                            		$dateval = date('l jS \of F Y',strtotime($row['date_entered']));

                            		if($replyby=='Reply by Client'){
                            			echo"<b>Message By You </b><br>";
                            		}else{
                            			echo"<b> Reply By CRM Agent</b></br>";
                            		}
                            		echo"<b>POSTED ON:</b>".$dateval."<br>".$row['description']."";

                            		echo"</div>";






                            	} 

                            	?>
                            	<input class="nextpage" type="hidden" value="5">
                            	<input class="isload" type="hidden" value="true">
                            	<input class="ids" type="hidden" value="<?php echo $ids;?>">

                            </div>
                            <?php 
                            $sql="SELECT * FROM pm_portalmessages as mesg INNER JOIN cases_pm_portalmessages_1_c as mesgcase ON mesgcase.cases_pm_portalmessages_1pm_portalmessages_idb=mesg.id INNER JOIN pm_portalmessages_cstm as replyuser ON replyuser.id_c=mesg.id  WHERE mesgcase.cases_pm_portalmessages_1cases_ida='".$ids."'";
                            $result = mysql_query($sql);
                            

                            if(mysql_num_rows($result)>5){ ?>
                            <input type="button" name="load_more" id='load_more' value='load more' style="float: right; margin: 0px 22px 0px 0px; text-transform: capitalize; width: 11%; font-size: 17px;">
                            <?php
                        }



                    }

                    ?>

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
                <script>
                	$(function() {
                		$( "#datepicker" ).datepicker();
                		$('input[type=file]').change(function(e){
                			var file = $('.flUpload')[0].files[0];
                			var fileName = file.name;
		  //alert(fileName);
		  $(".docname").val(fileName);

		});
                	});
                </script>

            </body>
            </html>
