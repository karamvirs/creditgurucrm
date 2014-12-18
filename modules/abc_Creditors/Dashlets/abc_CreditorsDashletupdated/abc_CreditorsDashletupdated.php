<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
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
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
?>
<script type="text/javascript">
	
		function deletestatus(x){
			$(function(){
					var data = "id=" + x;
					$.ajax({
                        type: "POST",
                        url: "abc_CreditorsDashletupdated_AJAX.php",
                        data: data,
                        dataType: 'text',
                        success: function (data) {
                            if (data) {
                               location.reload();
                            }
                        }
                    });

			});

		}
		

	

</script>
<?php 
require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/abc_Creditors/abc_Creditors.php');

class abc_CreditorsDashletupdated extends DashletGeneric { 
    function abc_CreditorsDashletupdated($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/abc_Creditors/Dashlets/abc_CreditorsDashletupdated/abc_CreditorsDashletupdated.data.php');

       parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = 'Updated Creditors ';

        $this->searchFields = $dashletData['abc_CreditorsDashletupdated']['searchFields'];
        $this->columns = $dashletData['abc_CreditorsDashletupdated']['columns'];

        $this->seedBean = new abc_Creditors();    
    }

       function process() { 
        global $current_language, $app_list_strings, $image_path, $current_user;   

        	 global $timedate, $current_user,$db;
        	     $lvsParams = array( 
                            'custom_select' => '', 
                            'custom_from' => '', 
							'custom_where' => ' AND abc_creditors_cstm.view_status_c= 1'
												
                     ); 
         
        	parent::process($lvsParams);
      // echo "<pre>";print_r($this->lvs->data['data'] );die;
        	foreach($this->lvs->data['data'] as $rowNum => $row) {
        		 
        		 $id = "'".$row['ID']."'";
			    $this->lvs->data['data'][$rowNum]['CLOSE'] = '<input type="button" name="close" value="close" class="closebt" onclick="deletestatus('.$id.')" />';
			    
			    if($row['EQUIFAX']==$row['EQUIFAX_OLD_C'])
			    	$val = '-no change-';
			    else
			    	$val = $row['EQUIFAX_OLD_C'].'=>'.$row['EQUIFAX'];
			    $this->lvs->data['data'][$rowNum]['EQUIFAX'] = $val; 			    

			    if($row['EXPERIAN']==$row['EXPERIAN_OLD_C'])
			    	$val = '-no change-';
			    else
			    	$val = $row['EXPERIAN_OLD_C'].'=>'.$row['EXPERIAN'];
			    $this->lvs->data['data'][$rowNum]['EXPERIAN'] = $val; 			    

			    if($row['TRANSUNION']==$row['TRANSUNION_OLD_C'])
			    	$val = '-no change-';
			    else
			    	$val = $row['TRANSUNION_OLD_C'].'=>'.$row['TRANSUNION'];
			    $this->lvs->data['data'][$rowNum]['TRANSUNION'] = $val; 

			  }

			  
        }
}