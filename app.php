<?php
// Includes
require_once("lib/base/Common.php");
require_once("lib/base/StandardQueryParameters.php");
require_once("lib/MySpace.php");

require_once("app-config.php"); // <-- SET YOUR KEY/SECRET HERE

// Set the key - application uri - secret key
$myspace = new MySpaceAPI(Config::$APP_OAUTH_CONSUMER_KEY, Config::$APP_OAUTH_CONSUMER_SECRET);

# checks for install param
$install=$HTTP_GET_VARS['install'];

# IF THE INSTALL PARAMETER EXISTS -- ie, the user as authenticated and this page
# has been hit by the install callback
# 
if ($install) {
	echo "You have installed an MySpace OAuth App.<br />";
	# checks for oauth_token in the URL params
	if (isset($_REQUEST["oauth_token"])) {
	     $request_token = $_REQUEST["oauth_token"];
	}
	# checks for oauth_token_secret in the URL params	
	if (isset($_REQUEST["oauth_token_secret"])) {
	     $request_token_secret = $_REQUEST["oauth_token_secret"];
	}
		
	# sets the request token
	$myspace->set_oauth_token($request_token);
	$myspace->set_oauth_token_secret($request_token_secret);
	
	# gets ths access token
	$access_token = $myspace->OAuthToken->get_access_token();	
	# not sure why this is necessary
	$req_token = $myspace->OAuthToken->get_token_from_url($access_token);
	$req_token_secret = $myspace->OAuthToken->get_token_secret_from_url($access_token);
		
	# reset the oauth request tokens. again, not sure why necessary
	$myspace->set_oauth_token($req_token);
	$myspace->set_oauth_token_secret($req_token_secret);
	
	// get the current user profile
	$result = $myspace->People->get_people_profile_current();
	$obj = json_decode($result);

	# print out some stuff
	echo "<br/>";
	echo "<big><strong>Here's some of your MySpace Data</strong></big>";
	echo "<br/>";
	echo "<br/>";
	echo "<img src=\"" . $obj->{'thumbnailUrl'} . "\"/>";
	echo "<br/>";
	echo "<strong>Name:</strong> " . $obj->{'name'}->{'unstructured'};
	echo "<br/>";	
	echo "<strong>About Yourself</strong>: " . $obj->{'aboutMe'};

	# get some friends (there's default pagination on this, so only gets 10 or so)
	$result = $myspace->People->get_people_friends_current();

	echo "<br/>";
	echo "<br/>";
	echo "<strong>Some of your friends: </strong>";
	
	# grabs all the friends id, returns as an array
	$friends = json_decode($result)->{'entry'};
	# loop through friends
	for ($i = 0; $i < count($friends); $i++) {
		# get the id
		$id = $friends[$i]->{'id'};
		# do another lookup for more data on that friend
		$result = $myspace->People->get_people_profile($id);
		echo "<br/>";
		# create a link to their user page using a default url
		echo "<a href=\"http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=" . preg_replace("/myspace\.com\:/", "", $id) . "\">" . json_decode($result)->{'name'}->{'unstructured'} . "</a>";
	}	
}
# Otherwise, assume that the user is coming to the page for the first time 
#
else {

	// Example Request using request/access
	$request_token = $myspace->OAuthToken->get_request_token();
	$req_token = $myspace->OAuthToken->get_token_from_url($request_token);
	$req_token_secret = $myspace->OAuthToken->get_token_secret_from_url($request_token);

	#$auth_url = $myspace->OAuthToken->get_authorization_url("http://www.techcrunch.com/myspace/app.php?install=1&oauth_token=" . $req_token . "&oauth_token_secret=" . $req_token_secret, $req_token);
	$auth_url = $myspace->OAuthToken->get_authorization_url("YOUR_HTTP_URL/app.php?install=1&oauth_token=" . $req_token . "&oauth_token_secret=" . $req_token_secret, $req_token);

	echo "Install a MySpace App: <a href=\"" . $auth_url . "\" target=\"_new\">click here</a>";
	echo "<br/>";
}

?>