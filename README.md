# rtCampTweet
This is a twitter timeline challenge based on rtCamp requirements using Twitter APIs with front-end coding using HTML and bootstrap and back-end using PHP and Javascript

Live demo : https://tweeterchallenge.herokuapp.com/

-> Login using your twitter account.</br>
-> Pulls tweets from your feed.</br>
-> Search for friends and their tweets.</br>
-> Download option for CSV and XLS file formats.</br>

## I also created the same assignment in a different template
Github Repo. : https://github.com/viral999g/Tweet  
Demo :  https://tchallenge.herokuapp.com/

<h2> Project structure</h2>
<pre>

rtcamp-twitter-challenge/
|_ _ _ _ css
|	     |_ _ _style.css
|
|_ _ _ _ lib
|        |_ _ _ twitteroauth
|               |_ _ _ OAuth.php
|               |_ _ _ twitteroauth.php
|        |_ _ _ excel.php
|
|_ _ _ _ js
|        |_ _ _ script.js
|        |_ _ _ strings.js
|        |_ _ _ Tweet.js
|        |_ _ _ TweetUI.js
|
|_ _ _ _ tests
|        |_ _ _ app
|               |_ _ _ controllers
|				       |_ _ _ core 
|				       		  |_ _ _ web
|				       		  		 |_ _ _ PagesTest.php
|
|_ _ _ _images
|		|_ _ _loading.gif
|		|_ _ _login-twitter.png
|
|_ _ _ _clearsession.php
|_ _ _ _ composer.json
|_ _ _ _ config.php
|_ _ _ _ generate_tweets_csv.php
|_ _ _ _ generate_tweets_xls.php
|_ _ _ _ get_tweets.php
|_ _ _ _ home.php
|_ _ _ _ index.php
|_ _ _ _ login.php
|_ _ _ _ redirect.php
|_ _ _ _ tweet_operations.php
|_ _ _ _ README.md

</pre>

## Creating your app
Create your own app on https://apps.twitter.com/

Now replace the consumer key and secret from you app to the following **config.php** file:

```
define('CONSUMER_KEY', 'Your Consumer Key');
define('CONSUMER_SECRET', 'Your Consumer Secret');
define('OAUTH_CALLBACK', 'Your callback url');
``` 

## PHPunit test
Create a **composer.json** file in your project directory and edit as follows:
```
{
	"require" : {
		"phpunit/phpunit": "^4.8"
	}
}

```
 Now from commandline run **composer require phpunit/phpunit** and let it install phpunit and its dependencies.

### Third party libraries
1. Twitter API
-https://dev.twitter.com/overview/documentation
2. Foundation CSS
-http://foundation.zurb.com/sites/docs/
3. Modernizer JS
-https://modernizr.com/docs
4. jQuery
-https://api.jquery.com/
5. Bootstrap
-http://getbootstrap.com/javascript/
6. PHPExcel
-https://phpexcel.codeplex.com/

## Author

Viral Gandhi
###[Github Profile](https://github.com/viral999G)

