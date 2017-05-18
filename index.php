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

// don't do more than 15 calls per 15 minutes (1 call every 1 minute should be enough)

$connection = new TwitterOAuth(API_CONSUMER_KEY, API_CONSUMER_SECRET,API_ACCESS_TOKEN,API_TOKEN_SECRET );
$tweets = $connection->get("statuses/user_timeline", ["screen_name" => "realDonaldTrump", "count" => 1, "trim_user" => true]);

//$user = $connection->get("users/show", ["screen_name" => "realDonaldTrump"]);

print_r($tweets);

//writeToCSV("data/users.csv",$tweets);


// Creates the file if it doesn't exists and writes to the end of it.
function writeToCSV($url,$dataArray) {
    $file = fopen($url,"a");

    foreach($dataArray as $line) {
        fputcsv($file,$line);
    }
    fclose($file);
}