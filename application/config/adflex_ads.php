<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | CPC
  |--------------------------------------------------------------------------
 */
$config['min_cpc'] = 0.01; // min CPC
$config['max_cpc'] = 100.00; // max CPC

/*
  |--------------------------------------------------------------------------
  | CPV
  |--------------------------------------------------------------------------
 */
$config['min_cpv'] = 1.00; // min CPV
$config['max_cpv'] = 100.00; // max CPV


/*
  |--------------------------------------------------------------------------
  | html 5 ads
  |--------------------------------------------------------------------------
 */

$config['max_title_len'] = 40;
$config['max_descr_len'] = 60;

$config['adflex'] = 'https://google.com'; // bad clicks url


/*
  |--------------------------------------------------------------------------
  | New ads image resize
  |--------------------------------------------------------------------------
 */
$config['ads_image_crop_width'] = 400;
$config['ads_image_crop_height'] = 300;


/*
  |--------------------------------------------------------------------------
  | Mobile unit params
  |--------------------------------------------------------------------------
 */
$config['mobile_unit_show_delay_min'] = 0;
$config['mobile_unit_show_delay_max'] = 360;

$config['mobile_unit_hidden_period_min'] = 0;
$config['mobile_unit_hidden_period_max'] = 86400;


/*
  |--------------------------------------------------------------------------
  | Maximum code length of a third-party advertising system (ad unit settings)
  |--------------------------------------------------------------------------
 */
$config['adunit_max_third_party_code_strlen'] = 3000;



