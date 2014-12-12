<?php require_once('./config_stripe.php'); 
$key = 'FG$%T';
$encrypted  = str_replace("::trsdftfghggfbg", '', base64_decode($_GET['u']));

//die($encrypted);
$fd = explode('&',$encrypted);
$amount = explode('=',$fd[0]);
$focus_id = explode('=',$fd[1]);
$focus_type = explode('=',$fd[2]);

//$finalvar = implode("=", $encrypted[1]);

?>

<form action="process_forms.php" method="post">
    <?php $amount = $amount[1] /100; ?>
    <input type="hidden" name="amount" value="<?php echo $amount ?>"  />
    <input type="hidden" name="focus_id" value="<?php echo $focus_id[1] ?>"  />
    <input type="hidden" name="focus_type" value="<?php echo $focus_type[1] ?>"  />
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-amount="<?php echo $amount[1] ?>" data-description="Payment"></script>
</form>
