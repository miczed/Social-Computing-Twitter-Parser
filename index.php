<?php

require "vendor/autoload.php";
require_once "keys.php";

use Abraham\TwitterOAuth\TwitterOAuth;

// don't do more than 15 calls per 15 minutes (1 call every 1 minute should be enough)

print_r("Connecting to twitter API ...");

$connection = new TwitterOAuth(API_CONSUMER_KEY, API_CONSUMER_SECRET,API_ACCESS_TOKEN,API_TOKEN_SECRET );
//$tweets = $connection->get("statuses/user_timeline", ["screen_name" => "realDonaldTrump", "count" => 1, "trim_user" => true]);


$user_sources = readCSV("data/user_sources.partial.csv");

$user_sources_length = count($user_sources);

foreach($user_sources as $index=>$user_source) {
    print_r("Getting user data for:\n");
    $userData = getUser($user_source[1],$connection);

    if($userData) {
        writeToCSV("data/users.csv",[$userData]);
    }

}

writeToCSV("data/users.csv",$userData);
print_r("Finished execution \n");

function getUser($screen_name,$connection) {

    $screen_name = trim($screen_name);
    $screen_name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $screen_name);
    $screen_name = ltrim($screen_name, '@');
    print_r("Getting user $screen_name from Twitter ...");

    $user = $connection->get("users/show", ["screen_name" => $screen_name]);

    if($user->id) {
        print_r("SUCCESS \n");
        return [$user->id,$user->screen_name,$user->name,$user->location, $user->description, $user->followers_count, $user->friends_count,$user->created_at, $user->verified, $user->lang,$user->profile_image_url,getCurrentDate()];
    } elseif($user->error) {
      print_r($user->error);
    } else {
        print_r("FAIL\n");
        print_r($user);
        return null;
    }

}


// Creates the file if it doesn't exists and writes to the end of it.
function writeToCSV($url,$dataArray) {
    print_r("Opening CSV file ... ");
    $file = fopen($url,"a");
    if($file) {
        print_r("SUCCESS\n");
    } else {
        print_r("FAILED\n");
    }

    foreach($dataArray as $line) {
        print_r("Writing line to CSV ... ");

        if(fputcsv($file,$line)) {
            print_r("SUCCESS\n");
        } else {
            print_r("FAIL\n");
        }
    }
    fclose($file);
}


// Reads a CSV file and returns an array
function readCSV($url) {
    $row = 0;
    $readData = [];
    print_r("Opening CSV File ... ");
    if (($handle = fopen($url, "r")) !== FALSE) {
        print_r("SUCCESS\n");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if($row!=0) { // skip first row
                $readData[$row] = $data;
            }

            $row++;
        }
        fclose($handle);
        return $readData;
    } else {
        print_r("FAIL\n");
        return null;
    }

}

function getDateForDatabase(string $date) : string {
    $timestamp = strtotime($date);
    $date_formated = date('Y-m-d H:i:s', $timestamp);
    return $date_formated;
}

function getCurrentDate(): string {
    return date('Y-m-d H:i:s');
}