Social-Computing-Twitter-Parser

#Setup

You need [composer](https://getcomposer.org/doc/00-intro.md) in order to install the dependencies for the projects. You also need a twitter developer account and valid keys.

1. Run `composer install` in the directory to install all the directories.
2. Create a `keys.php` file and insert your twitter API keys.

````
<?php
define('API_CONSUMER_KEY','your-valid-key');
define('API_CONSUMER_SECRET','your-valid-key');
define('API_ACCESS_TOKEN','your-valid-key');
define('API_TOKEN_SECRET','your-valid-key');
````
