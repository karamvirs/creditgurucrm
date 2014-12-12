<?php
  require_once(dirname(__FILE__) . '/config_stripe.php');
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
Stripe::setApiKey("sk_test_uheqxZhTOrQMmkY7YuzYRfRz");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

// Do something with $event_json
   mail("nnneerajjj@gmail.com","stripe response","response".print_r($event_json)." end","From: stripe-test@example.com");

http_response_code(200); // PHP 5.4 or greater

  
?>
