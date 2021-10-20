<?php
require('Stripe/stripe-php-master/init.php');

$publishableKey="pk_test_51JlSQwSFNgPd2ZmewWEd5KpDxkRvtDMKPXRvXaH711eet2u9Q8DVV2IUbMZppD7Pp1RvvYxAl2roJAOxw8zNia6d005p6BvKh2";

$secretKey="sk_test_51JlSQwSFNgPd2ZmeDIwqhe2Gsf4bzn5tNYlVoLdFsrNlJGhHwesfVIZvyLVNQ8JIr7fMN7MTRI1dYRx2b61qOaKT00QVey5Rv5";

\Stripe\Stripe::setApiKey($secretKey);
?>