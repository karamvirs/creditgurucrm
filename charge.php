<?php
  require_once(dirname(__FILE__) . '/config_stripe.php');

  $token  = $_POST['stripeToken'];

  $customer = Stripe_Customer::create(array(
      'email' => 'customer@example.com',
      'card'  => $token
  ));

  $charge = Stripe_Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $_POST['a'],
      'currency' => 'usd',
      "metadata" => array("crm_client_id" => $_POST['id'])
  ));

  echo '<h1>Successfully charged $50.00!</h1>';
?>


