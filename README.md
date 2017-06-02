Social-Computing-Twitter-Parser

## Setup

Since this script is using PHP you need to be able to run [php locally](http://php.net/manual/en/install.php).
You need [composer](https://getcomposer.org/doc/00-intro.md) in order to install the dependencies for the projects. 
You also need a [twitter developer account](https://dev.twitter.com/) with valid keys and a Google Cloud Computing project with valid credentials.

1. Run `composer install` in the directory to install all the directories.
2. Create a `keys.php` file and insert your twitter API keys and Google Cloud keys.
3. Run `php index.php` in the console


````
<?php
define('API_CONSUMER_KEY','your-valid-key');
define('API_CONSUMER_SECRET','your-valid-key');
define('API_ACCESS_TOKEN','your-valid-key');
define('API_TOKEN_SECRET','your-valid-key');
define('PROJECT_ID','your-google-cloud-project-id');
````

## Data

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

### 3. Sentiment Analysis
We sent all the tweets to Google's Cloud Natural Language to analyze the sentiment of the tweets. However, for our analysis we only used the tweets which have `twitter_language = 'en'`

## Results
You can find our results and source R files in this github repo.


## Credits
We got the initial list of people from wikipedia: https://en.wikipedia.org/wiki/List_of_current_heads_of_state_and_government
The population data for each country was downloaded from: http://www.statvision.com/webinars/countries%20of%20the%20world.xls

**June 2017**
Roman Bucher & Michael Ziörjen
