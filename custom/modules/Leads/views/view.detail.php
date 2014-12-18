<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 * ****************************************************************************** */


require_once('include/MVC/View/views/view.detail.php');

class LeadsViewDetail extends ViewDetail {

    function display() {
        global $sugar_config;
        ?>
        <div style="width: 20%; margin:0px auto">
            <input type='button' value='Send Quote' name='send' id='sent_detail' onclick=" $('#quotes_table').show();">
            <input type='button' value='Show Templates' name='send' id='sent_detail' onclick=" $('#templates_table').show();">
        </div>        


        <script>
            $(function () {

               /* $('#sent_detail').click(function () {

                    var email = $("#email12").val();

                    var data = "email=" + email;
                    $.ajax({
                        type: "POST",
                        url: "Leaddataajax.php",
                        data: data,
                        dataType: 'text',
                        success: function (data) {
                            if (data) {
                                alert(data);
                            }
                        }
                    });
                }); */

                /* Code for submiting the submit form that create and download the PDF from email templates */
                $('input[name=download_pdf]').live('click', function () {
                    $('input[name=mail_or_download]').val('download');
                    $('form[name=mailtemplates_form]').submit();
                });

                $('input[name=send_email]').live('click', function () {
                    $('input[name=mail_or_download]').val('mail');
                    $('form[name=mailtemplates_form]').submit();
                });
                
                /* Code for submiting the submit form that create and download the PDF from quote templates */
                 $('input[name=quote_download_pdf]').live('click', function () {
                    $('input[name=quote_mail_or_download]').val('download');
                    $('form[name=quotes_form]').submit();
                });

                $('input[name=quote_send_email]').live('click', function () {
                    $('input[name=quote_mail_or_download]').val('mail');
                    $('form[name=quotes_form]').submit();
                });

            });
        </script>
        <?php
        //If the convert lead action has been disabled for already converted leads, disable the action link.
        $disableConvert = ($this->bean->status == 'Converted' && !empty($sugar_config['disable_convert_lead'])) ? TRUE : FALSE;
        $this->ss->assign("DISABLE_CONVERT_ACTION", $disableConvert);
        parent::display();
    }

}
