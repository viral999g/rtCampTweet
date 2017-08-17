	<?php
	session_start();
	require_once ('lib/twitteroauth/twitteroauth.php');
	require_once ('config.php');

	// tf access tokens are not available,clear session and redirect to login page.
	if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
		header('Location: clearsession.php');
	}
	// get user access tokens from the session.
	$access_token = $_SESSION['access_token'];

	// create a TwitterOauth object with tokens.
	$twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

	// get the current user's info
	$user_info = $twitteroauth -> get('account/verify_credentials');

	if (isset($user_info -> errors) && $user_info -> errors[0] -> message == 'Rate limit exceeded') {
	//echo "<script>alert('Twetter auth Error: Rate limit exceeded'); </script>Go to Login Page click <a href='clearsession.php'>here</a>";
	//exit ;
	}

	//get the followers list
	$friend_list = $twitteroauth -> get("https://api.twitter.com/1.1/followers/list.json?cursor=-1&screen_name=" . $user_info -> screen_name . "&skip_status=true&include_user_entities=false&count=30");
	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<!-- Theme Made By www.w3schools.com - No Copyright -->
		<title>Twitter Challenge</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body style="padding: 0px;margin: 0px;overflow-x: hidden;">

		<div class="container-fluid" style="overflow-x: hidden;width: 100%;padding: 0px;margin: 0px;">



			<nav class="navbar navbar-inverse" style="margin: 0px;border-radius: 0px;background-color: #A569BD">
				<div class="container-fluid" style="overflow-x: hidden;width: 100%;padding: 0px;margin: 0px;">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>                        
						</button>
						
						<a class="navbar-brand" href="#" style="background: transparent;color: #fff;margin-left: 15px;"><i class="fa fa-twitter"></i>&nbsp&nbspTwitter</a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">

							<li style="background: transparent;color: #ffd;padding:0px 5px 0px 5px;"><img style="margin-right: 10px;" class="img-circle" src="<?php echo $user_info->profile_image_url;?>"><?php echo $user_info->name; ?> </li>

							<li id="export-csv"><a href="#" style="color: #fff;"><i class="fa fa-download"></i>&nbspCSV format</a></li>
							<li id="export-xls"><a href="#" style="color: #fff;"><i class="fa fa-download"></i>&nbspXLS format</a></li>
									
								</ul>
							</li>
							

						</ul>
						<ul class="nav navbar-nav navbar-right">

							
							<li class="active" id="home"><a style="background: transparent;color: #ffd" href="#">My feed</a></li>
							
							<li id="my-tweets"><a href="#" style="background: transparent;color: #ffd">My tweets</a></li>
							
							<li id="logout"><a href="clearsession.php" style="background: transparent;color: #ffd"><span class="glyphicon glyphicon-user"></span> Sign out</a></li>
							
						</ul>
					</div>
				</div>
			</nav>

			<div class="jumbotron text-center" style="margin-bottom: 2px;padding-left: 5px;background-color: #0084b4;border-radius: 0px;height: 300px;padding-top: 30px">
				<img src="<?php echo str_replace("_normal", "", "$user_info->profile_image_url");?>" class="img-circle profile-pic text-center" style="padding-top: 0px">
				<h3 class="text-center"><?php echo $user_info->name ?></h3>
				<label class="text-center">@<?php echo $user_info->screen_name ?></label> 
				<div class="profile_info" style="padding-left: 0px">
					<div class="row text-center" style="padding-left: 0px;">
						<div class="col-sm-4" style="display: inline-block;margin-left: 0px;padding: 10px">
							<label class="text-left">Followers</label>
							<p><?php echo $user_info->followers_count?></p>
						</div>


						<div class="col-sm-4" style="display: inline-block;margin-left: 0px;padding: 10px">
							<label class="text-left">Friends</label>
							<p><?php echo $user_info->friends_count?></p>
						</div>



						<div class="col-sm-4" style="display: inline-block;margin-left: 0px;padding: 10px">
							<label class="text-left">Tweets</label>
							<p><?php echo $user_info->statuses_count?></p>
						</div>
					</div>
				</div>

			</div>
		</div>


		<div class="col-sm-9" style="padding-left: 0px;">



			<div class="tweet-thread" style="width:100%;height: 1050px; overflow-y:scroll; margin-top: 10px;">
				<div id="loading-overlay">
					<img width="20%" src="images/loading.gif" alt='loading'>
				</div><!--//#loading-overlay-->
				<div class="large-12 columns" id="tweets">
					<script id="tweet-template" type="text/x-handlebars-template">
						{{#if this}}
						{{#data}}

						<div class="radius panel jumbotron" style="margin-top: 8px;background-color: #D1F2EB;">
							<div class="tweet bubble-left" id="{{id_str}}">
								<img class="img-circle" src="{{user.profile_image_url}}" alt="profile image">
								<label class="text-center" style="font-size: 15px;margin-left: 15px" id="">{{user.name}}<span><a style="margin-left: 5px" href="www.twitter.com/{{user.screen_name}}" target="_blank">@{{user.screen_name}}</a></span>&nbsp&nbsp<span class="tweet-timestamp" id="">{{getDateTime created_at}}</span></label>
								
								<p class="tweet-text" style="margin-top: 20px;font-size: 15px;background:transparent;color: #111">{{twityfy text}}</p>
								<p class="links" style="margin-top: 20px;color: #00f;">
									{{#if_eq user.screen_name compare="<?php echo $user_info->screen_name?>"}}
									<a href="javascript:void(0)" style="color: #000;font-size: 15px;" class="delete-tweet" title="Delete this tweet">Delete</a>
									{{else}}
									{{#if retweeted}}
									<a href="javascript:void(0)" style="color: #000;font-size: 15px;padding-left: 10px" class="retweeted" name="{{id_str}}" title="Undo retweet">Retweeted</a>
									{{else}}
									<a href="javascript:void(0)" style="color: #000;font-size: 15px;padding-left: 10px" class="retweet" title="Retweet">Retweet</a>
									{{/if}}
									{{/if_eq}}

									{{#if favorited}}
									<a href="javascript:void(0)" style="color: #000;font-size: 15px;padding-left: 10px" class="favorited" title="Undo favorite">Favorited</a>
									{{else}}
									<a href="javascript:void(0)" style="color: #000;font-size: 15px;padding-left: 10px" class="favorite" title="Favorite">Favorite</a>
									{{/if}}
								</p>
							</div>
						</div>
						{{/data}}
						{{else}}
						<div> No Tweets yet</div>
						{{/if}}
					</script>
				</div>
			</div>	

		</div>


		<div class="col-sm-3 sidenav" style="padding-left: 0px;padding-right: 0px;background-color: #D7BDE2;margin-top: 16px;border-radius: 15px ">
			<form class="navbar-formm navbar-left" style="margin-bottom: 2px;width: 100%;margin-left: 0px;border-radius: 15px">
				<div class="input-group"  style="width: 100%;margin-left: 0px;border-radius: 15px">
					<input type="text" class="form-control" style="background-color: #fff;border-bottom: 3px solid #BB8FCE;font-weight: bold;font-size: 15px;width: 100%;margin-left: 0px;height: 50px;border-radius: 15px" autocomplete="off" size="30" placeholder="Search followers..." id="filter">

				</div>
			</form>

			<div class="row" style="height: 999px; width:100%; overflow-y:scroll; margin-top: 5px;margin-left: 8px;border-radius: 2px">
				<ul class="tweet-user-list" style="padding: 5px;" >
					<?php 
					if($friend_list->users)
					{
						foreach ($friend_list->users as $friends) { ?>
						<li>
							<a href="javascript:void(0)" id="<?php echo $friends->screen_name?>" class="followers" >
								<div class="row jumbotron friend forhover" style="width:auto;margin: 0px;margin:2px;margin-left:8px;background:transparent;margin-bottom: 2px">
									<div class="col-sm-6"><img class="img-circle" src="<?php echo str_replace("_normal", "", "$friends->profile_image_url?"); ?>" alt="profile image" style="width: 100px;height: 100px;margin-left: calc(50% - 50px);"></div>
									<div class="col-sm-6" style="margin-top: 20px">
										<p class="text-center" style="font-size: 20px;font-weight: bolder;color: #fff"><?php echo $friends->name?></p>
										<p class="text-center" style="color: #ffc;font-weight: bold;">@<span class="text-center" style="font-size: 15px"><?php echo $friends->screen_name?></span></p>
									</div>
								</div>
							</a>
						</li>
						<?php }
					}
					?>
				</ul>
			</div>


		</div>

		<div class="modal fade" id="retweet-modal" role="dialog" style="margin-top: 200px" backdrop="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Retweet?</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you wan to retweet this?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" id="btn-retweet">Retweet</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="delete-modal" role="dialog" style="margin-top: 200px" backdrop="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delete?</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" id="btn-delete">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>

	</body>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.8.1.min.js"><\/script>')</script>
	<script src="js/foundation.js"></script>
	<script type="text/javascript" src="lib/handlebars.js"></script>
	<script type="text/javascript" src="lib/moment.js"></script>
	<script type="text/javascript" src="lib/bootstrap-modal.js"></script>
	<script type="text/javascript" src="js/handlebar-helper.js"></script>
	<script type="text/javascript" src="js/Tweet.js"></script>
	<script type="text/javascript" src="js/TweetUI.js"></script>     
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/strings.js"></script>
	<script type="text/javascript" src="js/foundation.dropdown.js"></script>
	<script>
		$(document).foundation();
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>



	</html>
