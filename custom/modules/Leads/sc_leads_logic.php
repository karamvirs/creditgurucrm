<?php

class SugarLogic {

    function add_action_button() {
        if ($GLOBALS['app']->controller->action == 'DetailView') {
            $json = file_get_contents('modules/sc_StripePayments/config.php');
            $settings = json_decode($json, true);
            $button_code = "
				<link rel='stylesheet' href='modules/sc_StripePayments/payment_form.css?v=" . time() . "'/>
				<script type=\"text/javascript\" src=\"https://js.stripe.com/v1/\"></script>
				<script type=\"text/javascript\">Stripe.setPublishableKey('" . $settings['publishable_key'] . "');</script>
				<script type=\"text/javascript\" src=\"modules/sc_StripePayments/payment_form.js?v=" . time() . "\"></script>
			";
            echo $button_code;
        }
    }

    function add_template_button() {
        global $db;
        if ($GLOBALS['app']->controller->action == 'DetailView') {
            $module = $_REQUEST['module'];

            /*
             * **** Code for getting mail templates
             * */
            $sql = "SELECT * FROM cet_customemailtemplates as cs JOIN cet_customemailtemplates_cstm as cst ON cs.id = cst.id_c WHERE cst.module_c = '$module'";
            $res = $db->query($sql);
            $table = "<form name='mailtemplates_form' action='saveaffiliate.php?action=leadsdetails' method='post'>";
            $table .= "<table class='list view' id='templates_table' style='display:none'><tr><td colspan=5><h2>Email Templates</h2>"
                    . "</td>"
                    . "</tr><tr><th width='5%'></th><th>Template</th></tr>";

            while ($row1 = $db->fetchByAssoc($res)) {
                $table .= "<tr>"
                        . "<td><input type='radio' name='selected_template' id='selected_template' value='{$row1['id']}'></td>"
                        . "<td>{$row1['name']}</td>";
                $table .= "</tr>";
            }
            $table .= "<tr>"
                    . "<th><input type='button' value = 'Download Pdf' name='download_pdf' /></th>"
                    . "<th ><input type='button' value = 'Send Email' name='send_email'/>"
                    . "<input type='hidden' name='mail_or_download'>"
                    . "<input type='hidden' name='email_form'>"
                    . "<input type='hidden' name='lead_id' value='" . $_REQUEST['record'] . "'>"
                    . " <input type='button' value='Cancel' onclick=$('#templates_table').hide();>"
                    . "</th>"
                    . "</tr>";
            $table .= "</table></form>";


            /*
             * **** Code for getting Quote templates
             * */

            $sql = "SELECT * FROM cet_customemailtemplates as cs JOIN cet_customemailtemplates_cstm as cst ON cs.id = cst.id_c WHERE cst.module_c = 'quote'";
            $res = $db->query($sql);
            $quote_table = "<form name='quotes_form' action='saveaffiliate.php?action=leadsdetails' method='post'>";
            $quote_table .= "<table class='list view' id='quotes_table' style='display:none'><tr><td colspan=5><h2>Quote Templates</h2>"
                    . "</td></tr><tr><th width='5%'></th><th>Template</th></tr>";

            while ($row1 = $db->fetchByAssoc($res)) {
                $quote_table .= "<tr>"
                        . "<td><input type='radio' name='selected_template' id='selected_template' value='{$row1['id']}'></td>"
                        . "<td>{$row1['name']}</td>";
                $quote_table .= "</tr>";
            }
            $quote_table .= "<tr>"
                    . "<th><input type='button' value = 'Download Pdf' name='quote_download_pdf' /></th>"
                    . "<th><input type='button' value = 'Send Email' name='quote_send_email'/>"
                    . "<input type='hidden' name='quote_mail_or_download'>"
                    . "<input type='hidden' name='quote_form'>"
                    . "<input type='hidden' name='lead_id' value='" . $_REQUEST['record'] . "'>"
                    . " <input type='button' value='Cancel' onclick=$('#quotes_table').hide(); >"
                    . "</th>"
                    . "</tr>";
            $quote_table .= "</table></form>";
            ?>

            <script>
                $(function () {
                    $("#Leads_detailview_tabs").before("<?php echo $table; ?>");
                    $("#Leads_detailview_tabs").before("<?php echo $quote_table; ?>");
                })
            </script> 
            <?php
        }
    }

    function assignToAffiliate($bean) {
        global $db;
        //echo"<pre>"; print_r($_SERVER);
        //die($_SERVER['HTTP_REFERER']);

        if ($_SERVER['HTTP_REFERER'] == "http://www.creditguruinc.com/") {
            $affilate_id = $_REQUEST['users_leads_1users_ida'];
            $sql = "SELECT * FROM  `affiliate_id` WHERE user_unique_id='$affilate_id'";
            $res = $db->query($sql);
            $row1 = $db->fetchByAssoc($res);
            $affiliate = $row1['user_id'];
        } else {

            $affiliate = $_REQUEST['users_leads_1users_ida'];
        }


        $id = create_guid();
        //Check if any affiliate is selcted or the field is empty
        if (!empty($affiliate)) {

            //Check if there is already an affiliate associate to this record
            $sql = "SELECT * FROM users_leads_1_c WHERE users_leads_1leads_idb = '$bean->id' AND deleted = 0";
            $res = $db->query($sql);
            $row1 = $db->fetchByAssoc($res);

            if (!empty($row1)) {

                //If there is already an affiliate , check if that and the current one in request are same.If not same then delete previous entry and insert new,else do nothing
                if ($row1['users_leads_1users_ida'] != $affiliate) {

                    $sql = "UPDATE users_leads_1_c SET deleted = 1 WHERE id = " . $row1['id'];
                    $db->query($sql);
                    $sql = "INSERT INTO users_leads_1_c VALUES ('$id',NOW(),0,'$affiliate','$bean->id')";
                    $db->query($sql);
                }
            } else {
                //If there is no affiliate already for this record then insert new row
                $sql = "INSERT INTO users_leads_1_c VALUES ('$id',NOW(),0,'$affiliate','$bean->id')";
                $db->query($sql);
            }
        } else {
            //If no affiliate is selected in the form delete any current affiliate association with the record
            $sql = "UPDATE users_leads_1_c SET deleted = 1 WHERE users_leads_1leads_idb = '$bean->id' AND deleted = 0";
            $db->query($sql);
        }
    }

}
?>