Social-Computing-Twitter-Parser

##Setup

Since this script is using PHP you need to be able to run [php locally](http://php.net/manual/en/install.php).
You need [composer](https://getcomposer.org/doc/00-intro.md) in order to install the dependencies for the projects. 
You also need a [twitter developer account](https://dev.twitter.com/) and valid keys.

1. Run `composer install` in the directory to install all the directories.
2. Create a `keys.php` file and insert your twitter API keys.
3. Run `php index.php` in the console


````
<?php
define('API_CONSUMER_KEY','your-valid-key');
define('API_CONSUMER_SECRET','your-valid-key');
define('API_ACCESS_TOKEN','your-valid-key');
define('API_TOKEN_SECRET','your-valid-key');
````

##Data

### Input Data

We collected the twitter account of the highest government officials of all the countries.
You can find the list of all twitter handles, real names and countries in `data/user_sources.csv`.

### Output Data

#### 1. User Accounts

We then fetched all the information from their twitter accounts and stored them in a CSV file: `data/users.csv`.

**Note**: We added a field called `date_crawled` in which we store the date / time when we fetched the data.  

#### 2. Tweets & Mentions 
In a second step we downloaded a maximum amount of 200 tweets per account and put them in another CSV file: `data/tweets.csv`. 
We created a separate CSV file `data/mentions.csv` to store the mentions of the tweets.