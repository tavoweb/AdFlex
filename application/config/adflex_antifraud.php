<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | clicks & impressions limits
  |--------------------------------------------------------------------------
 */

$config['enable_clicks_filter'] = (ENVIRONMENT === 'production'); // enable click filtering
$config['enable_views_filter'] = (ENVIRONMENT === 'production'); // enable impression filtering

$config["ad_views_limit"] = 50; // ad impression limit, for one unique IP per day
$config["unit_views_limit"] = 200; // ad unit impression limit, for one unique IP per day

$config["clicks_per_minute"] = 1; // limit on the number of clicks on the bundle - (ad unit + ad) for a unique IP in 1 minute
$config["clicks_per_hour"] = 3; // limit on the number of clicks on the bundle - (ad unit + ad) for a unique IP in 1 hour
$config["clicks_per_day"] = 10; // limit on the number of clicks on the bundle - (ad unit + ad) for a unique IP in day


/*
  |--------------------------------------------------------------------------
  |  Token lifetime of signature of announcements and statistics collection
  |  Affects the accounting statistics of impressions of ad units and announcements.
  |  Impression statistics will be counted for N seconds, starting from the time
  |  Insert ads on the page.
  |--------------------------------------------------------------------------
 */
$config['ad_hmac_expiration'] = 60; // seconds