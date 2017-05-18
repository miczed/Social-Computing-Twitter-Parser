<?php

require "vendor/autoload.php";
require_once "keys.php";

use Abraham\TwitterOAuth\TwitterOAuth;


print_r("Connecting to twitter API ...\n");

$connection = new TwitterOAuth(API_CONSUMER_KEY, API_CONSUMER_SECRET,API_ACCESS_TOKEN,API_TOKEN_SECRET );

//crawlTweets("data/users.csv","data/tweets.csv","data/mentions.csv",$connection);
//crawlUsers("data/user_sources.partial.csv","data/users.csv",$connection);


function crawlTweets($source_csv,$tweets_csv,$mentions_csv,$connection) {
    $user_sources = readCSV($source_csv);
    foreach($user_sources as $index=>$user_source) {

        $tweets = getTweets($user_source[1],$connection);

        if($tweets) {
            writeToCSV($tweets_csv,$tweets[0]);
            writeToCSV($mentions_csv,$tweets[1]);
        }

    }
}


function getTweets($screen_name,$connection) {
    $screen_name = cleanTwitterName($screen_name);
    print_r("Getting tweets from user $screen_name from Twitter ...");
    $tweets = $connection->get("statuses/user_timeline", ["screen_name" => $screen_name,"trim_user" => true]);
    if($tweets) {
        $csvData = [[],[]]; // tweets, user_mentions
        foreach($tweets as $tweet) {
            $csvData[0][] = [$tweet->id,$tweet->user->id,$tweet->created_at,$tweet->text,$tweet->source,$tweet->retweet_count,$tweet->favorite_count,$tweet->lang,getCurrentDate()];
            foreach($tweet->entities->user_mentions as $user_mention) {
                $csvData[1][] = [$tweet->id,$tweet->user->id,$user_mention->screen_name,$user_mention->name,$user_mention->id];
            }
        }
        print_r("SUCCESS \n");
        return $csvData;
    } else {
        print_r("FAIL \n");
        return null;
    }
}


function crawlUsers($source_csv,$target_csv,$connection) {
    $user_sources = readCSV($source_csv);

    $user_sources_length = count($user_sources);

    foreach($user_sources as $index=>$user_source) {
        print_r("Getting user data for:\n");
        $userData = getUser($user_source[1],$connection);

        if($userData) {
            writeToCSV($target_csv,[$userData]);
        }

    }
}


function cleanTwitterName($screen_name) {
    $screen_name = trim($screen_name);
    $screen_name = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $screen_name);
    $screen_name = ltrim($screen_name, '@');
    return $screen_name;
}

function getUser($screen_name,$connection) {

    $screen_name = cleanTwitterName($screen_name);
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