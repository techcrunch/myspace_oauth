<?php
// Includes
require_once("lib/base/Common.php");
require_once("lib/base/StandardQueryParameters.php");
require_once("lib/MySpace.php");

require_once("app-config.php"); // <-- SET YOUR KEY/SECRET HERE

// Set the key - application uri - secret key
$myspace = new MySpaceAPI(Config::$APP_OAUTH_CONSUMER_KEY, Config::$APP_OAUTH_CONSUMER_SECRET);

$install=$HTTP_GET_VARS['install'];

if ($install) {
	echo "You have installed the TechCrunch MySpace OAuth App.<br />";
	#for ($counter = 0; $counter < count($HTTP_GET_VARS); $counter += 1) {
   if (isset($_REQUEST["oauth_token"])) {
        $request_token = $_REQUEST["oauth_token"];
   }
   if (isset($_REQUEST["oauth_token_secret"])) {
        $request_token_secret = $_REQUEST["oauth_token_secret"];
   }
	#}
		
	$myspace->set_oauth_token($request_token);
	$myspace->set_oauth_token_secret($request_token_secret);
	
	$access_token = $myspace->OAuthToken->get_access_token();
	$req_token = $myspace->OAuthToken->get_token_from_url($access_token);
	$req_token_secret = $myspace->OAuthToken->get_token_secret_from_url($access_token);
	
	
	$myspace->set_oauth_token($req_token);
	$myspace->set_oauth_token_secret($req_token_secret);
	
	// get the current user profile and userId for other requests
	// --------------------------------------------------------------------
	$result = $myspace->People->get_people_profile_current();
	$obj = json_decode($result);

	echo "<br/>";
	echo "<big><strong>Here's some of your MySpace Data</strong></big>";
	echo "<br/>";
	echo "<br/>";
	echo "<img src=\"" . $obj->{'thumbnailUrl'} . "\"/>";
	echo "<br/>";
	echo "<strong>Name:</strong> " . $obj->{'name'}->{'unstructured'};
	echo "<br/>";	
	echo "<strong>About Yourself</strong>: " . $obj->{'aboutMe'};

	$result = $myspace->People->get_people_friends_current();

	echo "<br/>";
	echo "<br/>";
	echo "<strong>Some of your friends: </strong>";
	$friends = json_decode($result)->{'entry'};
	for ($i = 0; $i < count($friends); $i++) {
		$id = $friends[$i]->{'id'};
		$result = $myspace->People->get_people_profile($id);
		echo "<br/>";
		echo "<a href=\"http://profile.myspace.com/index.cfm?fuseaction=user.viewprofile&friendid=" . preg_replace("/myspace\.com\:/", "", $id) . "\">" . json_decode($result)->{'name'}->{'unstructured'} . "</a>";
	}	
}
else {

	// Example Request using request/access
	$request_token = $myspace->OAuthToken->get_request_token();
	$req_token = $myspace->OAuthToken->get_token_from_url($request_token);
	$req_token_secret = $myspace->OAuthToken->get_token_secret_from_url($request_token);

	$auth_url = $myspace->OAuthToken->get_authorization_url("http://www.techcrunch.com/myspace/app.php?install=1&oauth_token=" . $req_token . "&oauth_token_secret=" . $req_token_secret, $req_token);


	echo "Install a MySpace App: <a href=\"" . $auth_url . "\" target=\"_new\">click here</a>";
	echo "<br/>";
}

?>