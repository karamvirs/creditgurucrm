<?php

ini_set('display_errors', 'off');
error_reporting(0);
if (!defined('sugarEntry'))
    define('sugarEntry', true);
include ('include/MVC/preDispatch.php');
$startTime = microtime(true);
require_once('include/entryPoint.php');


require_once('include/MVC/SugarApplication.php');
require_once('modules/Users/User.php');
global $db;



$id_guid = create_guid();
if ($_REQUEST['source'] == 'cgwebsite') {
    $u = new User();
    $name = explode(' ', trim($_REQUEST['input_1']));
    if (!empty($name)) {
        $u->last_name = $name[1];
        $u->first_name = $name[0];
    } else {
        $u->first_name = $_REQUEST['input_1'];
    }

    // $u->first_name=$_REQUEST['input_1'];
    $u->user_name = $_REQUEST['input_3'];
    $u->status = 'Active';
    $u->employee_status = 'Active';
    $random_password = '123456';
    $u->user_password = $u->encrypt_password($random_password);
    $u->user_hash = strtolower(md5($random_password));
    $u->email1 = $_REQUEST['input_3'];
    $u->referred_by_c = $_REQUEST['input_10'];

    $prog = trim($_REQUEST['input_8']);

    switch ($prog) {

        case '$99 Affiliate Program':
            $u->affiliate_program_c = '99_affiliate_program';
            break;
        case '$199 Affiliate Program':
            $u->affiliate_program_c = '199_affiliate_program';
            break;
    }

    $u->phone_mobile = $_REQUEST['input_2'];
    $u->save();

    require_once('modules/Roles/Role.php');
    $focus = new Role();
    $focus->retrieve('24505155-5513-3db9-68b4-53f2e885c9f1'); //the id of the role you created 
    $focus->set_user_relationship($focus->id, $u->id); //id gets set after doing $u->save();  
    //Assign the affilate role to user
    $affiliate_id = '24505155-5513-3db9-68b4-53f2e885c9f1';
    $user_id = $u->id;
    $sql = "INSERT INTO acl_roles_users VALUES ('$id_guid','$affiliate_id','$user_id',NOW(),0)";
    $db->query($sql);


    //Send the affilate password to user
    $email = $_REQUEST['input_3'];
    $to = $email;
    $subject = "New account information";

    $message = "
              <html>
              <head>
              <title>New account information</title>
              </head>
              <body>
              <p>Hi your account has been created by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> with following credentials.<br /> Email: " . $email . " <br/>Password: " . $random_password . "<br />After you log in using the above password, you may be required to reset the password to one of your own choice<br><br/>Thanks, <br />Credit Guru</p>
              </body>
              </html>
              ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <creditguru@example.com>' . "\r\n";
    //$headers .= 'Cc: myboss@example.com' . "\r\n";

    if (mail($to, $subject, $message, $headers)) {
        //die('send');
    }
}
//For lead creditors 



/*
 * ********** Download PDF or send mail
 *  */
if (!function_exists('p')) {

    function p($a) {
        echo "<pre>";
        print_r($a);
        echo "</pre>";
    }

}
if ($_REQUEST['action'] == 'leadsdetails' AND isset($_REQUEST['mail_or_download'])) {
    require_once("dompdf/dompdf_config.inc.php");
    require_once("dompdf/dompdf_config.inc.php");
    $lead_id = $_REQUEST['lead_id'];
    //Get Email And PDF layout
    $sql = "SELECT * FROM cet_customemailtemplates as cet JOIN cet_customemailtemplates_cstm as cus ON cet.id=cus.id_c
    WHERE id = '" . $_REQUEST['selected_template'] . "'";
    $qry = $db->query($sql);
    $tmpl = $db->fetchByAssoc($qry);
    $desc_data = html_entity_decode($tmpl['description']);
    $final_data = explode('{{attachment}}', $desc_data);
    

        //Get Lead Email Id
        $sql ="SELECT * FROM email_addresses AS ead
        JOIN email_addr_bean_rel AS eb ON ead.id = eb.email_address_id
        WHERE eb.bean_id ='$lead_id' AND eb.deleted =  '0'";
        $qry=$db->query($sql);
        $emaillead = $db->fetchByAssoc($qry);



        $sql = "SELECT * FROM leads l JOIN leads_cstm lc ON l.id = lc.id_c WHERE id = '$lead_id'";
        $qry = $db->query($sql);
        $lead = $db->fetchByAssoc($qry);
    if(!empty($final_data[1])){

        $html = $final_data[1];
        $html = "<html><body>$html</body></html>"; 

        $sql = "SELECT * 
        FROM leads_abc_creditors_1_c AS leads 
        JOIN abc_creditors 
        ON leads_abc_creditors_1abc_creditors_idb = abc_creditors.id 
        JOIN abc_creditors_cstm 
        ON abc_creditors.id = abc_creditors_cstm.id_c 
        WHERE  leads.leads_abc_creditors_1leads_ida = 
        '$lead_id' 
        AND abc_creditors.deleted = 0 ";
        $result = $db->query($sql);
        $table = "<h2>Creditor Report</h2>"
        . "<table width='100%' border='1' text-align='center'>"
        . "<tr>"
        . "<th>Name</th>"
        . "<th>Experian</th>"
        . "<th>Equifax</th>"
        . "<th>Transunion</th>"
        . "</tr>";
        while ($res = $db->fetchByAssoc($result)) {
            $table .= "<tr>"
            . "<td>{$res['name']}</td>"
            . "<td>{$res['experian']}</td>"
            . "<td>{$res['equifax']}</td>"
            . "<td>{$res['transunion']}</td>";
            $table .= "</tr>";
        }

        $table .= "</table>";


        $html = str_replace('{{first_name}}', $lead['first_name'], $html);
        $html = str_replace('{{last_name}}', $lead['last_name'], $html);
        $html = str_replace('{{quoted_amount}}', $lead['quoted_amount_c'], $html);
        $html = str_replace('{{paid_amount}}', $lead['paid_amount_c'], $html);
        $html = str_replace('{{balance_amount}}', $lead['balance_amount_c'], $html);
        $html = str_replace('{{report}}',$table,$html);
    }/*else{

        $html = "<html><body>Hi</body></html>"; 
        $sql = "SELECT * 
        FROM leads_abc_creditors_1_c AS leads 
        JOIN abc_creditors 
        ON leads_abc_creditors_1abc_creditors_idb = abc_creditors.id 
        JOIN abc_creditors_cstm 
        ON abc_creditors.id = abc_creditors_cstm.id_c 
        WHERE  leads.leads_abc_creditors_1leads_ida = 
        '$lead_id' 
        AND abc_creditors.deleted = 0 ";
        $result = $db->query($sql);
        $table = "<h2>Creditor Report</h2>"
        . "<table width='100%' border='1' text-align='center'>"
        . "<tr>"
        . "<th>Name</th>"
        . "<th>Experian</th>"
        . "<th>Equifax</th>"
        . "<th>Transunion</th>"
        . "</tr>";
        while ($res = $db->fetchByAssoc($result)) {
            $table .= "<tr>"
            . "<td>{$res['name']}</td>"
            . "<td>{$res['experian']}</td>"
            . "<td>{$res['equifax']}</td>"
            . "<td>{$res['transunion']}</td>";
            $table .= "</tr>";
        }
 
        $table .= "</table>";
        $html = str_replace('{{report}}',$table,$html);
    }*/ 

    if ($_REQUEST['mail_or_download'] == 'download') {
       $dompdf = new DOMPDF();
       $dompdf->load_html($html);
       $dompdf->render();
       $dompdf->stream("record.pdf");
   }else if ($_REQUEST['mail_or_download'] == 'mail') {

    $email  =$emaillead['email_address'];
    $to = $email;
    $subject = $tmpl['subject_c'];
   
     

    if(!empty($final_data[0])){
        die("here");
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('pdf/record.pdf', $output);

            $newhtml =html_entity_decode($final_data[0]);

            $filename = 'record.pdf';
            $file = 'pdf/record.pdf';
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
            $uid = md5(uniqid(time())); 
            $name = basename($file);

                $header = "MIME-Version: 1.0\r\n";
                $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
                $header .= "This is a multi-part message in MIME format.\r\n";
                $header .= "--".$uid."\r\n";
                $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $header .= $message."\r\n\r\n";
                $header .= "--".$uid."\r\n";
                $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
                $header .= "Content-Type: application/pdf\r\n";
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
                $header .= $content."\r\n\r\n";
                $header .= "--".$uid."--";
                // More headers
                $headers .= 'From: <webmaster@example.com>' . "\r\n";
                $headers .= 'Cc: myboss@example.com' . "\r\n";
        }else{
            die("next");

           $newhtml =  $tmpl['description'];
           $header = "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
         $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        }
     $message = $newhtml;
    $newhtml = str_replace('{{first_name}}', $lead['first_name'], $newhtml);
    $newhtml = str_replace('{{last_name}}', $lead['last_name'], $newhtml);
    $newhtml = str_replace('{{quoted_amount}}', $lead['quoted_amount_c'], $newhtml);
    $newhtml = str_replace('{{paid_amount}}', $lead['paid_amount_c'], $newhtml);
    $newhtml = str_replace('{{balance_amount}}', $lead['balance_amount_c'], $newhtml);

    
    

            // Always set content-type when sending HTML email
   

                if(mail($to,$subject,$message,$header)){

                    header('Location:index.php?module=Leads&action=DetailView&record='.$lead_id);
                }
            }

        } 
/*** FOR CLIENT EMAIL AND PDF*****/

if ($_REQUEST['action'] == 'clientdetails' AND isset($_REQUEST['mail_or_download'])) {
    require_once("dompdf/dompdf_config.inc.php");
    require_once("dompdf/dompdf_config.inc.php");
    $client_id = $_REQUEST['client_id'];
    //Get Email And PDF layout
    $sql = "SELECT * FROM cet_customemailtemplates as cet JOIN cet_customemailtemplates_cstm as cus ON cet.id=cus.id_c
    WHERE id = '" . $_REQUEST['selected_template'] . "'";
    $qry = $db->query($sql);
    $tmpl = $db->fetchByAssoc($qry);
    $desc_data = html_entity_decode($tmpl['description']);
    $final_data = explode('{{attachment}}', $desc_data);
    $html = $final_data[1];

    //Get Client Email Id
    $sql ="SELECT * FROM email_addresses AS ead
    JOIN email_addr_bean_rel AS eb ON ead.id = eb.email_address_id
    WHERE eb.bean_id ='$client_id' AND eb.deleted =  '0'";
    $qry=$db->query($sql);
    $emaillead = $db->fetchByAssoc($qry);
    


    $sql = "SELECT * FROM contacts l JOIN contacts_cstm lc ON l.id = lc.id_c WHERE id = '$client_id'";
    $qry = $db->query($sql);
    $lead = $db->fetchByAssoc($qry);

    $html = "<html><body>$html</body></html>"; 
     $sql="SELECT * FROM
       abc_creditors_contacts_c  
       JOIN
       abc_creditors    
       ON abc_creditors_contactsabc_creditors_idb = abc_creditors.id  
       JOIN
       abc_creditors_cstm    
       ON abc_creditors.id = abc_creditors_cstm.id_c  
       WHERE
       abc_creditors_contacts_c.abc_creditors_contactscontacts_ida = '$client_id'  
       AND abc_creditors.deleted = 0";

    $result = $db->query($sql);
    $table = "<h2>Creditor Report</h2>"
    . "<table width='100%' border='1' text-align='center'>"
    . "<tr>"
    . "<th>Name</th>"
    . "<th>Experian</th>"
    . "<th>Equifax</th>"
    . "<th>Transunion</th>"
    . "</tr>";
    while ($res = $db->fetchByAssoc($result)) {
        $table .= "<tr>"
        . "<td>{$res['name']}</td>"
        . "<td>{$res['experian']}</td>"
        . "<td>{$res['equifax']}</td>"
        . "<td>{$res['transunion']}</td>";
        $table .= "</tr>";
    }

    $table .= "</table>";


    $html = str_replace('{{first_name}}', $lead['first_name'], $html);
    $html = str_replace('{{last_name}}', $lead['last_name'], $html);
    $html = str_replace('{{quoted_amount}}', $lead['quoted_amount_c'], $html);
    $html = str_replace('{{paid_amount}}', $lead['paid_amount_c'], $html);
    $html = str_replace('{{balance_amount}}', $lead['balance_amount_c'], $html);

    $html = str_replace('{{report}}',$table,$html);


    if ($_REQUEST['mail_or_download'] == 'download') {
       $dompdf = new DOMPDF();
       $dompdf->load_html($html);
       $dompdf->render();
       $dompdf->stream("record.pdf");
   }else if ($_REQUEST['mail_or_download'] == 'mail') {

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('pdf/record.pdf', $output); 
    
    
    $newhtml =html_entity_decode($final_data[0]);
    
    $newhtml = str_replace('{{first_name}}', $lead['first_name'], $newhtml);
    $newhtml = str_replace('{{last_name}}', $lead['last_name'], $newhtml);
    $newhtml = str_replace('{{quoted_amount}}', $lead['quoted_amount_c'], $newhtml);
    $newhtml = str_replace('{{paid_amount}}', $lead['paid_amount_c'], $newhtml);
    $newhtml = str_replace('{{balance_amount}}', $lead['balance_amount_c'], $newhtml);

    $email  =$emaillead['email_address'];
    $to = $email;
    $subject = $tmpl['subject_c'];
    $message = $newhtml;
    $filename = 'record.pdf';
    $file = 'pdf/record.pdf';
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);

     // Always set content-type when sending HTML email
    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
                $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
                $header .= "Content-Type: application/pdf\r\n";
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
                $header .= $content."\r\n\r\n";
                $header .= "--".$uid."--";
                // More headers
                $headers .= 'From: <webmaster@example.com>' . "\r\n";
                $headers .= 'Cc: myboss@example.com' . "\r\n";

                if(mail($to,$subject,$message,$header)){
                    
                    header('Location:index.php?module=Contacts&action=DetailView&record='.$client_id);
                }
            }

        }
?>