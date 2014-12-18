<?php
 
// this file is upgrade safe
// location: custom/modules/Contacts/views/view.detail.php
 
require_once('modules/Contacts/views/view.detail.php');
 
class CustomContactsViewDetail extends ContactsViewDetail {
/**
* @see SugarView::display()
*
* We are overriding the display method to manipulate the portal information.
* If portal is not enabled then don't show the portal fields.
*/
  public function preDisplay()
  {
    parent::preDisplay();
    $this->dv->setup($this->module, $this->bean, 'custom/modules/Contacts/metadata/detailviewdefs.php', get_custom_file_if_exists('modules/Contacts/tpls/DetailView.tpl'));
  }

  public function display(){
  	global $db;

    $balance = $this->bean->quoted_amount_c - $this->bean->paid_amount_c;
    $request_amount = ($this->bean->quoted_amount_c) ? $this->bean->quoted_amount_c / 3 : 0;
    $request_amount = ($request_amount > $balance) ? $balance : $request_amount;
    //assign value
    $this->ss->assign("request_amount", $request_amount);    
	  // my custom code here
	  
	   
            $module ='payment';
             $sql = "SELECT * FROM cet_customemailtemplates as cs JOIN cet_customemailtemplates_cstm as cst ON cs.id = cst.id_c WHERE cst.module_c = '$module'";
			$res = $db->query($sql);
			
			
			$dropbox .="<select name='selected_template' id='selected_template'>";
			while ($row1 = $db->fetchByAssoc($res)) {
                $dropbox .= "<option id='selected_template' value='".$row1['id']."'>".$row1['name']."</option>";
                        
            }
			 $dropbox .="</select>";
		 $this->ss->assign("dropbox", $dropbox); 
			
		

	  // call up the ContactsViewDetail Code to run the display after we have called
	  // all of our custom code.
    parent::display();
	?>
	
	<script>
		$(function(){
			var ids ='<?php echo $this->bean->id;?>';
			var number = 0;
			$( 'span.sugar_field' ).click(function() {
				number++;
				var filedname = $(this).html();
				var divid = $(this).attr('id');
				if(divid=="birthdate" || divid=="portal_password_c" || divid=="balance_amount_c" || divid=="assigned_user_id" )
				{
				}else{
					$(this).after('<input type="text" value="'+filedname+'" name="fillfiled_' + (number) +'" class="fillfiled"> ');

					$(this).hide();
					$(".fillfiled").blur('click', function() {
						var newfilename = $(this).val();
						if(filedname!=newfilename)
						{
							var data='filedvlaue='+newfilename+'&id='+ids+'&divid='+divid;
							$.ajax({
								type: 'POST',
								url: 'ajax.php',
								data:data,
								success: function(data){
									if(data){
										var arr =data.split(',');
										arr[0];
										if(arr[1]){
											$('#'+arr[0]).html(arr[1]);
										}
										$('#'+arr[0]).show();
										$('.fillfiled').hide();
									}
									
								}
							})

						}else{

							$('span.sugar_field').show();
							$('.fillfiled').hide();
						}



					});
				}


			}); 
<?php if(empty($this->bean->portal_password_c)){?>


	$( '#sendemail' ).click(function() {
		var c_id  = $("#c_id").val();
		var data="catid="+c_id;
		$.ajax({ 
			type: "POST",
			url: "ajaxbutton.php",
			data: data,
			dataType: 'text',
			success: function(data){
				if(data){
					alert(data);
					$('#sendemail').hide();
				}

			}

		})
	});
	<?php }else{?>
		$('#sendemail').hide();
		
		<?php } ?>


		/* Code for submiting the submit form that create and download the PDF from email templates */
		$('input[name=send]').live('click',function(){
			
			$('#templates_table').toggle();
			
		});
		$('input[name=download_pdf]').live('click',function(){

			$('input[name=mail_or_download]').val('download');
			$('form[name=mailtemplates_form]').submit();
		});

		$('input[name=send_email]').live('click',function(){
			$('input[name=mail_or_download]').val('mail');
			$('form[name=mailtemplates_form]').submit();
		});
		

	})


	</script>
	
	<?php
    echo "<script>
	
	function send_payment_request_email(){ 
    email = $('#client_email_req').val();
    amount = $('#request_amount').val();
	template = $('#selected_template').val();
    if(amount >  $balance ){
        alert('Requested payment amount cannot be greater than the balance amount.');
        return false;       
    }
    $.post('send_payment_request_email.php', {email: email, id: '".$this->bean->id."', module: 'Contacts', amount: amount ,template: template}, function(data){ $('#email_err').html(data); if(data == 'Email sent'){ $('#payment_modal').hide() } else{}  }) }</script>";
  }
}
