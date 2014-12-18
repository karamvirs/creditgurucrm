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
            $module = 'clients';
            $sql = "SELECT * FROM cet_customemailtemplates as cs JOIN cet_customemailtemplates_cstm as cst ON cs.id = cst.id_c WHERE cst.module_c = '$module'";

            $res = $db->query($sql);
            $table = "<form name='mailtemplates_form' action='saveaffiliate.php?action=clientdetails' method='post'>";
            $table .= "<table class='list view' id='templates_table' style='display:none'><tr><td colspan=5><h2>Email Templates</h2></td></tr><tr><th width='5%'>Select</th><th>Template</th></tr>";

            while ($row1 = $db->fetchByAssoc($res)) {
                $table .= "<tr>"
                        . "<td><input type='radio' name='selected_template' id='selected_template' value='{$row1['id']}'></td>"
                        . "<td>{$row1['name']}</td>";
                $table .= "</tr>";
            }
            $table .= "<tr>"
                    . "<th><input type='button' value = 'Download Pdf' name='download_pdf' /></th>"
                    . "<th><input type='button' value = 'Send Email' name='send_email'/>"
                    . "<input type='hidden' name='mail_or_download'>"
                    . "<input type='hidden' name='client_id' value='" . $_REQUEST['record'] . "'>"
                    . "  <input type='button' value='Cancel' onclick=$('#templates_table').hide();>"
                    . "</th>"
                    . "</tr>";
            $table .= "</table></form>";
            //echo $table;
            ?>

            <script>$(function () {
                    $("#Contacts_detailview_tabs").before("<?php echo $table; ?>");

                })</script> 
            <?php
        }
    }

    function assignToAffiliate($bean) {

        global $db;
        $affiliate = $_REQUEST['users_contacts_1users_ida'];
        $id = create_guid();
        //Check if any affiliate is selcted or the field is empty
        if (!empty($affiliate)) {

            //Check if there is already an affiliate associate to this record
            $sql = "SELECT * FROM users_contacts_1_c WHERE users_contacts_1contacts_idb = '$bean->id' AND deleted = 0";
            $res = $db->query($sql);
            $row1 = $db->fetchByAssoc($res);

            if (!empty($row1)) {
                //If there is already an affiliate , check if that and the current one in request are same.If not same then delete previous entry and insert new,else do nothing
                if ($row1['users_contacts_1users_ida'] != $affiliate) {

                    $sql = "UPDATE users_contacts_1_c SET deleted = 1 WHERE id = " . $row1['id'];
                    $db->query($sql);
                    $sql = "INSERT INTO users_contacts_1_c VALUES ('$id',NOW(),0,'$affiliate','$bean->id')";
                    $db->query($sql);
                }
            } else {
                //If there is no affiliate already for this record then insert new row
                $sql = "INSERT INTO users_contacts_1_c VALUES ('$id',NOW(),0,'$affiliate','$bean->id')";
                $db->query($sql);
            }
        } else {
            //If no affiliate is selected in the form delete any current affiliate association with the record
            $sql = "UPDATE users_contacts_1_c SET deleted = 1 WHERE users_contacts_1contacts_idb = '$bean->id' AND deleted = 0";
            $db->query($sql);
        }
    }

}
?>