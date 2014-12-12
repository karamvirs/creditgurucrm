<?php

// this file is upgrade safe
// location: custom/modules/Users/views/view.detail.php
 
require_once('modules/Users/views/view.detail.php');
 
class CustomUsersViewDetail extends UsersViewDetail {
/**
* @see SugarView::display()
*
* We are overriding the display method to manipulate the portal information.
* If portal is not enabled then don't show the portal fields.
*/
  public function preDisplay()
  {
    global $db;
    $id  = $this->bean->id; 
    $sql = "SELECT * FROM affiliate_id WHERE user_id='$id'";
    $res = $db->query($sql);
    $result = $db->fetchByAssoc($res);
    $user_assign_id = $result['user_unique_id'];
    $this->ss->assign('user_assign_id',$user_assign_id);
 // print_r($this->bean->user_hash);



 // die('aaaaaa');
    parent::preDisplay();
    $this->dv->setup($this->module, $this->bean, 'custom/modules/Users/metadata/detailviewdefs.php', get_custom_file_if_exists('modules/Users/tpls/DetailView.tpl'));
  }
/*
  public function display(){

    $balance = $this->bean->quoted_amount_c - $this->bean->paid_amount_c;
    $request_amount = ($this->bean->quoted_amount_c) ? $this->bean->quoted_amount_c / 3 : 0;
    $request_amount = ($request_amount > $balance) ? $balance : $request_amount;
    //assign value
    $this->ss->assign("request_amount", $request_amount);    
  // my custom code here

  // call up the ContactsViewDetail Code to run the display after we have called
  // all of our custom code.
    parent::display();
    echo "<script>function send_payment_request_email(){ 
    email = $('#client_email_req').val();
    amount = $('#request_amount').val();
    if(amount >  $balance ){
        alert('Requested payment amount cannot be greater than the balance amount.');
        return false;       
    }
    $.post('send_payment_request_email.php', {email: email, id: '".$this->bean->id."', module: 'Contacts', amount: amount}, function(data){ $('#email_err').html(data); if(data == 'Email sent'){ $('#payment_modal').hide() } else{}  }) }</script>";
  }
*/
  
  /*
  //function to show the "affiliate Program" field only if the role is "Affiliate"
  function display(){ // add this if function display doesn't exist  
                  global $current_user;
                  // check if current user is in specific role
                  // code taken from thread
                  unset($this->dv->focus->affiliate_program_c);//die;
                  unset($this->dv->ss->_tpl_vars['MOD']['LBL_AFFILIATE_PROGRAM']);
                  
                  $is_affiliate = in_array("affiliate role", ACLRole::getUserRoleNames($current_user->id));
                  if($is_affiliate)
                      $this->ev->ss->assign('readOnly', 'readonly = "readonly"');
                  else
                      $this->ev->ss->assign('readOnly', '');
                    
                  parent::display(); // add this if function display doesn't exist 
  } // add this if function display doesn't exist
  */
}
