<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | payments & payouts
  |--------------------------------------------------------------------------
 */
$config['min_payment'] = 1.00;
$config['max_payment'] = 1000.00;

$config['allowed_payment_gateways'] = ['paypal', 'stripe'];
$config['allowed_payment_currencies'] = ['USD', 'EUR']; // uppercase!

$config['paypal_api_url'] = 'https://www.paypal.com/cgi-bin/webscr';
$config['paypal_api_url_sandbox'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

$config['min_payout_sum'] = 10.00;
