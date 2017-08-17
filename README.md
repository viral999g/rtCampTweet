# rtCampTweet
This is a twitter timeline challenge based on rtCamp requirements using Twitter APIs with front-end coding using HTML and bootstrap and back-end using PHP and Javascript

Live demo : https://tweeterchallenge.herokuapp.com/

-> Login using your twitter account.</br>
-> Pulls tweets from your feed.</br>
-> Search for friends and their tweets.</br>
-> Download option for CSV and XLS file formats.</br>

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
