<?php
require_once('./lib/Stripe.php');

$stripe = array(
  "secret_key"      => "sk_test_uheqxZhTOrQMmkY7YuzYRfRz",
  "publishable_key" => "pk_test_evpO8dJTly3wZegA3VHBDlpL"
);

Stripe::setApiKey($stripe['secret_key']);
?>
