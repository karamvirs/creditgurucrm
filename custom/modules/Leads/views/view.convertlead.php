<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("modules/Leads/views/view.convertlead.php");

class CustomViewConvertLead extends ViewConvertLead 
{
    /**
     * Saves a new Contact as well as any related items passed in.
     *
     * @return null
     */
    protected function handleSave()
    {
        global $db;
        require_once('modules/Campaigns/utils.php');
        require_once("include/formbase.php");
        $lead = false;
        if (!empty($_REQUEST['record']))
        {
            $lead = new Lead();
            $lead->retrieve($_REQUEST['record']);
        }

        global $beanList;
        $this->loadDefs();
        $beans = array();
        $selectedBeans = array();
        $selects = array();
        
        // Make sure the contact object is availible for relationships.
        $beans['Contacts'] = new Contact();
        
        // Contacts
        if (!empty($_REQUEST['selectedContact']))
        {
            $beans['Contacts']->retrieve($_REQUEST['selectedContact']);
            if (!empty($beans['Contacts']->id))
            {
                $beans['Contacts']->new_with_id = false;
                unset($_REQUEST["convert_create_Contacts"]);
                unset($_POST["convert_create_Contacts"]);
            }
        }
        elseif (!empty($_REQUEST["convert_create_Contacts"]) && $_REQUEST["convert_create_Contacts"] != "false" && !isset($_POST['ContinueContact'])) 
        {
            require_once('modules/Contacts/ContactFormBase.php');
            $contactForm = new ContactFormBase();
            $duplicateContacts = $contactForm->checkForDuplicates('Contacts');

            if (isset($duplicateContacts))
            {
                echo $contactForm->buildTableForm($duplicateContacts,  'Contacts');
                return;
            }
            $this->new_contact = true;
        } elseif (isset($_POST['ContinueContact'])) {
            $this->new_contact = true;
        }
        // Accounts
        if (!empty($_REQUEST['selectedAccount']))
        {
            $_REQUEST['account_id'] = $_REQUEST['selectedAccount'];
            unset($_REQUEST["convert_create_Accounts"]);
            unset($_POST["convert_create_Accounts"]);
        }
        elseif (!empty($_REQUEST["convert_create_Accounts"]) && $_REQUEST["convert_create_Accounts"] != "false" && empty($_POST['ContinueAccount']))
        {
            require_once('modules/Accounts/AccountFormBase.php');
            $accountForm = new AccountFormBase();
            $duplicateAccounts = $accountForm->checkForDuplicates('Accounts');
            if (isset($duplicateAccounts))
            {
                echo $accountForm->buildTableForm($duplicateAccounts);
                return;
            }
        }

        foreach ($this->defs as $module => $vdef)
        {
            //Create a new record if "create" was selected
        	if (!empty($_REQUEST["convert_create_$module"]) && $_REQUEST["convert_create_$module"] != "false")
            {
                //Save the new record
                $bean = $beanList[$module];
	            if (empty($beans[$module]))
	            	$beans[$module] = new $bean();

            	$this->populateNewBean($module, $beans[$module], $beans['Contacts'], $lead);
                // when creating a new contact, create the id for linking with other modules
                // and do not populate it with lead's old account_id
                if ($module == 'Contacts')
                {
                    $beans[$module]->id = create_guid();
                    $beans[$module]->new_with_id = true;
                    $beans[$module]->account_id = '';
                }
            }
            //If an existing bean was selected, relate it to the contact
            else if (!empty($vdef['ConvertLead']['select'])) 
            {
                //Save the new record
                $select = $vdef['ConvertLead']['select'];
                $fieldDef = $beans['Contacts']->field_defs[$select];
                if (!empty($fieldDef['id_name']) && !empty($_REQUEST[$fieldDef['id_name']]))
                {
                    $beans['Contacts']->$fieldDef['id_name'] = $_REQUEST[$fieldDef['id_name']];
                    $selects[$module] = $_REQUEST[$fieldDef['id_name']];
                    if (!empty($_REQUEST[$select]))
                    {
                        $beans['Contacts']->$select = $_REQUEST[$select];
                    }
                    // Bug 39268 - Add the existing beans to a list of beans we'll potentially add the lead's activities to
                    $bean = loadBean($module);
                    $bean->retrieve($_REQUEST[$fieldDef['id_name']]);
                    $selectedBeans[$module] = $bean;
                    // If we selected the Contact, just overwrite the $beans['Contacts']
                    if ($module == 'Contacts')
                    {
                        $beans[$module] = $bean;
                    }
                }
            }
        }

        $this->handleActivities($lead, $beans);
        // Bug 39268 - Add the lead's activities to the selected beans
        $this->handleActivities($lead, $selectedBeans);

        //link selected account to lead if it exists
        if (!empty($selectedBeans['Accounts']))
        {
            $lead->account_id = $selectedBeans['Accounts']->id;
        }
        
        // link account to contact, if we picked an existing contact and created a new account
        if (!empty($beans['Accounts']->id) && !empty($beans['Contacts']->account_id) 
                && $beans['Accounts']->id != $beans['Contacts']->account_id)
        {
            $beans['Contacts']->account_id = $beans['Accounts']->id;
        }
        
        // Saving beans with priorities.
        // Contacts and Accounts should be saved before lead activities to create correct relations
        $saveBeanPriority = array('Contacts', 'Accounts');
        $tempBeans = array();

        foreach ($saveBeanPriority as $name)
        {
            if (isset($beans[$name]))
            {
                $tempBeans[$name] = $beans[$name];
            }
        }

        $beans = array_merge($tempBeans, $beans);
        unset($tempBeans);

        //Handle non-contacts relationships
        foreach ($beans as $bean)
        {
            if (!empty($lead))
            {
                if (empty($bean->assigned_user_id))
                {
                    $bean->assigned_user_id = $lead->assigned_user_id;
                }
                $leadsRel = $this->findRelationship($bean, $lead);
                if (!empty($leadsRel))
                {
                    $bean->load_relationship($leadsRel);
                    $relObject = $bean->$leadsRel->getRelationshipObject();
                    if ($relObject->relationship_type == "one-to-many" && $bean->$leadsRel->_get_bean_position())
                    {
                        $id_field = $relObject->rhs_key;
                        $lead->$id_field = $bean->id;
                    }
                    else 
                    {
                        $bean->$leadsRel->add($lead->id);
                    }
                }
            }
            //Special case code for opportunities->Accounts
            if ($bean->object_name == "Opportunity" && empty($bean->account_id))
            {
                if (isset($beans['Accounts']))
                {
                    $bean->account_id = $beans['Accounts']->id;
                    $bean->account_name = $beans['Accounts']->name;
                }
                else if (!empty($selects['Accounts']))
                {
                    $bean->account_id = $selects['Accounts'];
                }
            }

            //create meetings-users relationship
            if ($bean->object_name == "Meeting")
            {
                $bean = $this->setMeetingsUsersRelationship($bean);
            }
            $this->copyAddressFields($bean, $beans['Contacts']);

            $bean->save();
            //if campaign id exists then there should be an entry in campaign_log table for the newly created contact: bug 44522	
            if (isset($lead->campaign_id) && $lead->campaign_id != null && $bean->object_name == "Contact")
            {
                campaign_log_lead_or_contact_entry($lead->campaign_id, $lead, $beans['Contacts'], 'contact');
            }
        }
        if (!empty($lead))
        {	
			$sql ="SELECT leads_abc_creditors_1abc_creditors_idb FROM `leads_abc_creditors_1_c` WHERE `leads_abc_creditors_1leads_ida` = '{$lead->id}'";
			 $results = $db->query($sql,true);
			//$currentdate = date();
			 while($res = $db->fetchByAssoc($results))
					{
						 $relation_id = create_guid();
						 $sql = "INSERT INTO `abc_creditors_contacts_c`(id,`date_modified`,`deleted`, `abc_creditors_contactscontacts_ida`, `abc_creditors_contactsabc_creditors_idb`) VALUES ('{$relation_id}',now(),0,'".$beans['Contacts']->id."','".$res['leads_abc_creditors_1abc_creditors_idb']."')";
						$result = $db->query($sql);
					}
		
		  // Get Affiliate ID
		  $query = "SELECT `ul`.`users_leads_1users_ida`
              FROM `leads` AS `l`
              JOIN `users_leads_1_c` AS `ul` ON `l`.`id` = `ul`.`users_leads_1leads_idb`
              WHERE `l`.`id` = '{$lead->id}'
              AND `ul`.`deleted` =0
              AND `l`.`deleted` =0
              LIMIT 0 , 1";
			      $result = $db->query($query,true);
            while($row = $db->fetchByAssoc($result))
            {
                /*We also need to add code to check if while converting the lead , admin chooses an existing client then 
                instead of straightaway inserting a new row in the users_contacts_1_c table, first check if the current affiliate of the client and the affiliate of the lead are same.If same then dont do anything.If different then we need to decide what to do?leave the affiliate as it is or update it to the affiliate of the lead
                */

                $relation_id = create_guid();
			    // Relate affiliate to contact
		        $query = "INSERT INTO `users_contacts_1_c` (
                `id` ,
                `date_modified` ,
                `deleted` ,
                `users_contacts_1users_ida` ,
                `users_contacts_1contacts_idb`)
              VALUES (
                '{$relation_id}', now() , '0', '".$row['users_leads_1users_ida']."', '".$beans['Contacts']->id."'
              );";
			        $result = $db->query($query);
					//$lastid =mysql_insert_id();
					
            }
            
            $alphabet = "abcdefghijklmnopqrstuwxyz"; //ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789"
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $random_password = implode($pass); //turn the array into a string

            $contact_id = $beans['Contacts']->id;
            $sql = "UPDATE `contacts_cstm` SET `portal_password_c` = '$random_password' WHERE `contacts_cstm`.`id_c` = '$contact_id';";
            $result = $db->query($sql);
            
            $to = $beans['Contacts']->email1;
            $subject = "Welcome to Credit guru";

            $message = "
            <html>
            <head>
            <title>Welcome to Credit Guru</title>
            </head>
            <body>
            <p>Hi ".$beans['Contacts']->salutation." ".$beans['Contacts']->first_name." ".$beans['Contacts']->last_name.",<br /><br /> Your account has been created by Credit guru. You can login at <a href='http://192.232.214.244/sugarcrm/portal/'>portal</a> with following credentials.<br /> Email: ".$beans['Contacts']->email1." <br/>Password: ".$random_password."<br /><br/>Thanks, <br />Credit Guru</p>
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
                //die('ss');
            }

            //Mark the original Lead converted
            $lead->status = "Converted";
            $lead->converted = '1';
            $lead->in_workflow = true;
            $lead->save();
        }

        $this->displaySaveResults($beans);
    }
}
