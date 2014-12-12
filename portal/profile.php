<?php
include('session.php');

$contact_result = mysql_query("select c.*, cc.* from contacts as c join contacts_cstm as cc  on c.id = cc.id_c where c.id='$login_session'", $connection);

$contact = mysql_fetch_array($contact_result);
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
 $unique_id=guidfinal();

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
  <script type="text/javascript">


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
<style>.odd{background:#DCE6F7} 
  .odd_div{  background: none repeat scroll 0 0 #dce6f7;
    border-radius: 10px;
    margin: 10px 23px;
    padding: 10px;
    width: 96%;}
    .even_div {
      text-align: right;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 11px;
      margin: 10px 0px;
    }


  </style>
</head>
<body class="skin-blue">
  <input type="hidden" name="next_load" id='next_load' value="true">
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
 <?php 
 if($contact['portal_password_changed_c']=='' or $contact['portal_password_changed_c']==0 or $_GET['action']=="changepwd"){
   if($_POST['submit']){
    $pass = $_POST['contact_pass'];
    $sql = "UPDATE `contacts_cstm` SET `portal_password_c` = '".$pass."',`portal_password_changed_c` = '1' WHERE `contacts_cstm`.`id_c` = '".$contact['id_c']."'";
    $result = mysql_query($sql);
    if($result){
      echo '<h3>Password Updated</h3>';
      echo"<script>window.location.href = 'http://192.232.214.244/sugarcrm/portal/profile.php';</script>";
    }


  }

  ?>
  <div id="login" class="box box-primary">
    <form action="" method="post" onsubmit="return Checkpass();">
      <div class="box-body">
        <div class="box-header">
         <h3 class="box-title">Change Password</h3>
       </div>

       <div class="form-group">
        <input type="password" name="contact_pass" id="pass" placeholder="Password" class="form-control">
      </div>
      <div class="form-group">
        <input type="password" name="conf_pass" id="cpass" placeholder="Confirm Password" class="form-control">
      </div>
      <div class="box-footer">
        <input type="submit" name="submit" value="Change Password" class="btn btn-primary">
      </div>
    </form>
  </div></div>
  <?php }else{?>

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
    <section class="content">

      <div id="profile">
        <?php 
        $sql12="SELECT * FROM `email_addr_bean_rel` WHERE `bean_id`= '1' AND `deleted`='0' ";
        $res12 = mysql_query($sql12);
        $row12=mysql_fetch_array($res12);
        $emailid =$row12['email_address_id'];
        $sql13="SELECT * FROM `email_addresses` WHERE `id`= '".$emailid."' AND `deleted`='0' ";
        $res13 = mysql_query($sql13);
        $row13=mysql_fetch_array($res13);
        $adminemail =  $row13['email_address'];


        ?>
      </div>
      <?php
/// SHOW Creditors
      if($_GET['action']=="creditors"){


       $sql="SELECT * FROM
       abc_creditors_contacts_c  
       JOIN
       abc_creditors    
       ON abc_creditors_contactsabc_creditors_idb = abc_creditors.id  
       JOIN
       abc_creditors_cstm    
       ON abc_creditors.id = abc_creditors_cstm.id_c  
       WHERE
       abc_creditors_contacts_c.abc_creditors_contactscontacts_ida = '".$contact['id']."'  
       AND abc_creditors.deleted = 0";
       $res = mysql_query($sql);
       echo'<table  id="example" class="display" width="100%" cellspacing="0">';




       echo "<tr><th>Creditor</th><th>Status</th><th>Experian</th><th>Equifax</th><th>Trans union</th><th>View Detail</th></tr>";
       $i = 0; 

       while($row=mysql_fetch_array($res))
       {
         

        ?>
        <tr class="<?php if($i % 2 == 0){ echo"odd"; }else{echo"even"; }?>">
         <?php
         echo"<td>".$row['name']."</td><td>".$row['status']."</td><td>".$row['experian']."</td><td>".$row['equifax']."</td><td>".$row['transunion']."</td><td><a href='details.php?a=cre&record=".$row['id']."'>View Details</a></td></tr>";
         $i++;

       }
       echo"</table>";
     }else{

      if($_GET['action']=="notes"){ ?>

      <h3>Notes Section</h3>
      <?php 
		//Notes Section
      $sql="SELECT *  FROM `notes` WHERE `contact_id`='".$contact['id']."' AND `portal_flag`=1";
      $res = mysql_query($sql);
      echo'<table border="1" cellpadding="5" cellspacing="0" width="1200px" >
      <tr><th>Subject</th><th>Status</th><th>Description</th><th>Contact</th><th>Date Modified</th><th>Date Created</th><th>File Name</th></tr>';
      $i=0;

      while($row=mysql_fetch_array($res))
      {   

       $url = "http://192.232.214.244/sugarcrm/index.php?entryPoint=download&id=".$row['id']."&type=Notes";
       ?>
       <tr class="<?php if($i % 2 == 0){ echo"odd"; }else{echo"even"; }?>">

         <?php
         echo"<td>".$row['name']."</td><td>Note</td><td>".$row['description']."</td><td>".$contact['first_name']." ".$contact['last_name']."</td><td>".$row['date_modified']."</td><td>".$row['date_entered']."</td><td><a href='".$url."'>".$row['filename']."</a></td></tr>";
         $i++;

       }
       echo"</table>";

     }else if($_GET['action']=="message"){


       $id = $contact['id'];


       $sql="SELECT * FROM pm_portalmessages as m INNER JOIN pm_portalmessages_contacts_c as c
       ON m.id=c.pm_portalmessages_contactspm_portalmessages_idb 
       INNER JOIN pm_portalmessages_cstm as cs
       ON m.id=cs.id_c
       WHERE c.pm_portalmessages_contactscontacts_ida='$id' ORDER BY  m.`date_entered` DESC";
       $res = mysql_query($sql);

       echo"<ul class='pagination1'>";
       while($row=mysql_fetch_array($res))
       {

        $des = $row['description'];
        $val_id =$row['id'];
        $replyby =$row['reply_by_c'];

        ?>
        <li>
          <div class="<?php if($replyby=='Reply by Client'){ echo"odd_div"; }else{echo"even_div"; }?>">

           <?php
           $dateval = date('l jS \of F Y h:i:s A',strtotime($row['date_entered']));

           if($replyby=='Reply by Client'){
            echo"<b>Message By You </b><br>";
          }else{
           echo"<b> Reply By CRM Agent</b></br>";
         }
         echo"<b>POSTED ON:</b>".$dateval."<br>".$row['description']."";

         echo"</div> </li>";

       }
       echo"</ul>";

     }elseif($_GET['action']=='SendMesg'){



      if(isset($_REQUEST['send'])){
        $des=$_REQUEST['mesg'];
        $c_id=$contact['id'];
        if(!empty($des)){
  				//insert on pm_portalmessages table
          $sql="INSERT INTO `pm_portalmessages` VALUES ('$unique_id','',NOW(),NOW(),'1','1','$des','0','') ";
          $res = mysql_query($sql);
          if($res){echo"<b style='color:green'>Message Sent</b>";
        }

  				  //create a reletionship 
        function uniqueids(){
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
              $u_id=uniqueids();

              $query ="INSERT INTO `pm_portalmessages_contacts_c` VALUES ('$u_id',NOW(),'0','$c_id','$unique_id')";
              $res = mysql_query($query);

  				//Add on  pm_portalmessages_cstm tables

              $sql1 = "INSERT INTO pm_portalmessages_cstm VALUES('$unique_id','Reply by Client')";
              mysql_query($sql1);
            }
            else{

              echo"<b style='color:red'>Please add message</b>";
            }

          }

          ?>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="box-header">
              <h3 class="box-title">Send Message</h3>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">MESSAGE: *</label>

              <textarea name="mesg" class="docname form-control"></textarea> 
            </div>

            <div class="form-group">

              <input type="submit" value="Send" name="send" class="btn btn-primary">
            </div>
          </form>

          <?php
          //Create New cases And View all Cases
        }else if($_GET['action']=='cases'){

          $sql1="SELECT * FROM  `accounts_contacts` WHERE  `contact_id`='".$contact['id']."'";
          $res= mysql_query($sql1);
          $result= mysql_fetch_array($res);
          if(isset($_REQUEST['sendmesg'])){

            $sendmesg = $_REQUEST['sendmesg_text'];
            $subject = $_REQUEST['subject'];
            if(!empty($_REQUEST['subject']) && !empty($_REQUEST['sendmesg_text'])){

            //relate the case to the default CRM account	
             $sql="INSERT INTO `cases` VALUES('$unique_id', '$subject', NOW(), NOW(), '1', '1', '$sendmesg', '0', '', '', '', 'New', 'P1', '', '', '".$result['account_id']."')  ";
             if(mysql_query($sql)){
             $guid = guidfinal();
             $sql = "INSERT INTO contacts_cases VALUES ('$guid','".$contact['id']."','".$unique_id."','',NOW(),0)";	
             if(mysql_query($sql))
              	echo "Case Created successfully";
            }
          }else{
            echo"<h6 style='color:red;'>Please Fill Subject and Message</h6>";
          }
        }

        ?>
        <button id="createcase" style="float: right; background: none repeat scroll 0px 0px rgb(60, 141, 188); border: medium none; padding: 6px 20px; color: rgb(255, 255, 255); margin-right: 30px;">New Discussion</button>
        <div class="mesgclass" style="margin: 0px auto; width: 95%; overflow:hidden;display:none">
         <h4 style='display:none;color:red' id='error_both'>Please Fill Both Fields</h4>
         <form action="" method="post"  id='mesgsubmit'>
           Discussion Topic: <input type="text" name="subject" value="" style="width: 100%; margin: 8px 0px;" id="topic_name"><br>
           Description:<textarea id="topic_des" name='sendmesg_text' style="width: 100%; height: 23%;margin-bottom: 14px;margin-top:15px;"></textarea><br>
           <input type="submit" name="sendmesg" value="Create Discussion" style="float: right; background: #3c8dbc;border: 0px;color: #fff; padding: 5px 20px;">
         </form>
       </div>
       

       <?php 


       $accountid =$result['account_id'];
       $sql="SELECT c.* FROM  `cases` as c JOIN contacts_cases as cc ON c.id = cc.case_id WHERE cc.contact_id ='".$contact['id']."' ORDER BY  `date_entered` DESC";
       $query=mysql_query($sql);
       echo'<table class="display dataTable" width="100%" cellspacing="0"><tr><th>Discussion Number</th><th>Name</th><th>Created Date</th><th>Status</th><tr></tr></tr>';
       while($results=mysql_fetch_array($query)){
         
        $dateval = date('D jS \of M Y',strtotime($results['date_entered']));

        echo"<tr><td>".$results['case_number']."</td><td>".$results['name']."</td><td>".$dateval."</td><td>".$results['status']."</td><td><a href='details.php?a=messages&record=".$results['id']."'>View Meassge</a></td></tr>";
        

        

      } 
      echo"</table>";
      
      
       //Amount Section//
    }else{if($_GET['action']!="changepwd")
    {

      ?>	 <div class="box box-success" style="float: left; padding: 10px; width: 39%;">
      <table border="1" cellpadding="5" cellspacing="0" width="400px" >
        <div class="box-header">
          <h3 class="box-title">Amount Section</h3>
        </div>

        <tr><td>Quoted Amount: </td><td><?php echo $contact['quoted_amount_c'];?></td></tr>
        <tr><td>Paid Amount: </td><td><?php echo $contact['paid_amount_c'];?></td></tr>
        <tr><td>Blance Amount: </td><td><?php echo $contact['balance_amount_c'];?></td></tr>
      </table>
    </div>

    <?php 
		//Upload DOC
    if(isset($_POST['upload'])){

     function getGUID(){
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
       $relation_id =getGUID();
       $docname = $_POST['name'];
       $filename = $_FILES["file"]["name"];
       $revision = $_POST['Revision'];
       $publishdate = date('Y-m-d');
       $temp = explode(".", $_FILES["file"]["name"]);
       $extension = end($temp);
       $filetype= $_FILES["file"]["type"];
       $newfilename = $relation_id.".".$extension;
       $path = realpath(dirname(__FILE__) . '/../upload/');
       $old=$path.'/'.$newfilename;

       if( move_uploaded_file($_FILES["file"]["tmp_name"],"$path/" . $newfilename)){

         $sql = "INSERT INTO `documents`(`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `assigned_user_id`, `document_name`, `doc_id`, `doc_type`, `doc_url`, `active_date`, `exp_date`, `category_id`, `subcategory_id`, `status_id`, `document_revision_id`, `related_doc_id`, `related_doc_rev_id`, `is_template`, `template_type`)VALUES('$relation_id',now(),now(),'1','1','NULL','0','NULL','".$docname."','','Sugar','','".$publishdate."','NULL','NULL','NULL','NULL','','NULL','NULL','0','NULL') ";

         $res =mysql_query($sql);

         if($res){
          function GUID(){
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
              $re_id=GUID();
              $sql ="INSERT INTO `documents_contacts`(`id`, `date_modified`, `deleted`, `document_id`, `contact_id`) VALUES ('$re_id',now(),'0','".$relation_id."','".$contact['id']."')";
              $res1 =mysql_query($sql);
              if($res1){
               function DID(){
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

                   $res_id=DID();
                   $sql ="INSERT INTO `document_revisions`(`id`, `change_log`, `document_id`, `doc_id`, `doc_type`, `doc_url`, `date_entered`, `created_by`, `filename`, `file_ext`, `file_mime_type`, `revision`, `deleted`, `date_modified`) VALUES ('$res_id','Document Created','".$relation_id."','','Sugar','',now(),'1','".$filename."','".$extension."','".$filetype."','".$revision."','0',now())";
                   $res3 =mysql_query($sql);
                   $sql1 = "UPDATE `documents` SET `document_revision_id`='$res_id'  WHERE id='".$relation_id."'";
                   $res3 =mysql_query($sql1);

                 }
               }

               $newname = $path.'/'.$res_id;

               $to = $adminemail;
               $subject = "Document is uploaded from portal account";

               $message = "
               <html>
               <head>
                 <title>Document is uploaded from portal account</title>
               </head>
               <body>
                 <p>Document is uploaded from portal account.<br>
                   Client Name: $contact[salutation] $contact[first_name] $contact[last_name]<br>
                   Futher View the document <a href='http://192.232.214.244/sugarcrm/index.php?module=Contacts&action=DetailView&record=$contact[id]' target='_blank'>CLICK HERE</a>


                 </p>
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
                echo "<h3 style='color:green'>Document Uploaded successfully</h3>";
              }	


            } 
            rename ("$old", "$newname");






          }
          ?> 
          <div class="box box-success"  style="float: left; width: 52%; margin-left: 80px; padding: 20px;">

            <form action="" method="post" enctype="multipart/form-data" onsubmit="return onforval()">
              <div class="box-header">
                <h3 class="box-title">Upload Document</h3>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">File Name: *</label>
                <input type="file" name="file" class="flUpload" id="files">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Document Name: *</label>
                <input type="text" name="name" VALUE="" class="docname form-control" id="doc">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Revision: *</label>
                <input type="text" name="Revision" value='1' class="form-control" id="res">
              </div>
              <div class="form-group">

                <input type="submit" value="Upload file" name="upload" class="btn btn-primary">
              </div>
            </form>
          </div>
          <?php }

        }
      } 

    }?>

  </section><!-- /.content -->
</aside><!-- /.right-side -->
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
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script src="http://cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
<script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $('input[type=file]').change(function(e){
      var file = $('.flUpload')[0].files[0];
      var fileName = file.name;
		  //alert(fileName);
		  $(".docname").val(fileName);

   });

    $('#example').dataTable( {
     "pagingType": "full_numbers"
   } );


    $( "#createcase" ).click(function() {
      $( ".mesgclass" ).toggle("slow");
    });


    $("#mesgsubmit").submit(function(){
   // alert("Submitted");
   var topic = $('#topic_name').val();
   var topic_des = $('#topic_des').val();
   if(topic.length == 0 || topic_des.length == 0){
    $('#error_both').css('display','block');
    return false;
  }

});
  });

  function onforval(){
   var file = $("#files").val();
   var doc = $("#doc").val();
   var res=$("#res").val();
   if(file==""){
     alert("select the file");
     return false;
   }else if(doc==""){
    alert("Please enter doc name");
    return false;
  }else if(res==""){
    alert("Please enter res name");
    return false;

  }



}
</script>

</html>
