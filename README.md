Social-Computing-Twitter-Parser

#Setup
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
