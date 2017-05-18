<?php
/**
 * Created by PhpStorm.
 * User: michaelziorjen
 * Date: 16.05.17
 * Time: 15:57
 */

require "vendor/autoload.php";
require_once "keys.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(API_CONSUMER_KEY, API_CONSUMER_SECRET,API_ACCESS_TOKEN,API_TOKEN_SECRET );
$tweets = $connection->get("statuses/user_timeline", ["screen_name" => "realDonaldTrump", "count" => 1, "trim_user" => true]);

//$user = $connection->get("users/show", ["screen_name" => "realDonaldTrump"]);

print_r($tweets);