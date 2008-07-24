<?php

require_once("lib/base/Common.php");
require_once("lib/base/OAuthBaseAPI.php");

class OAuthTokenAPI extends OAuthBaseAPI {
    //ctor
    public function __construct($application_key, $application_secret) {
        $this->application_key = $application_key;
        $this->application_secret = $application_secret;
        
        $this->oauth_consumer = new OAuthConsumer($this->application_key, $this->application_secret);
        $this->oauth_token = null;//new OAuthToken(null, null);
        $this->oauth_token_secret = null;
        
        $this->api_version = ApiVersionType::$VERSION_V2;
        
        $this->resource_base = CommonConstants::$URL_ROOT_API;
        $this->response_type = ResponseType::$JSON;
    }

    public function validate_oauth($oauth_signature) {
        //TODO:
    }
    
    public function get_request_token() {
        //$oauthServer = new OAuthServer( fetch_request_token
        
        $resource = '/request_token';
        //var_dump($resource);
        $result = $this->do_get_raw($resource, null);
        //var_dump($result);
        //$result = $this->get_token_from_url($result);        
        return $result;

        //$resource = 'request_token';
        //$result = $this->do_get($resource, null);
        //var_dump($result);
        //return $result["token"];
    }
    
    public function get_access_token() {
        $resource = sprintf('/access_token');
        $result = $this->do_get_raw($resource, null);
        
        //echo "---\n";
        //var_dump($result);
        //echo "---\n";
        
        //$result = $this->get_token_from_url($result);
        return $result;        

        //echo $result;
        //$resource = sprintf('access_token');
        //$result = $this->do_get($resource, null);
        //return $result["token"];
    }
    
    public function get_token_from_url($data) {
        return $this->get_from_url(OAuthConstants::$OAUTH_TOKEN, $data);
    }
    
    public function get_token_secret_from_url($data) {
        return $this->get_from_url(OAuthConstants::$OAUTH_TOKEN_SECRET, $data);
    }
    
    public function get_from_url($param_key, $data) {
        $results = explode("&", $data);
        
        foreach($results as $value) {
            $query = explode("=", $value);
            
            //var_dump($query[0]);
            
            if ($query[0] == $param_key) {
                //var_dump($query[1]);
                return urldecode($query[1]);
                //return $query[1];
            }
        }
    }
    
    //public function get_authtoken($user_id) {        
    //    $resource = sprintf('authtoken/%s', $user_id);
    //    $result = $this->do_get_raw($resource, null);
    //    return $result["token"];
    //}	
    
    public function get_authorization_url($callbak_url, $request_token) {
        $resource = '/authorize';
        $this->resource_uri = $resource;
        $querystring = '?' . OAuthConstants::$OAUTH_TOKEN . '=' . urlencode($request_token) . '&' . OAuthConstants::$QS_OAUTH_CALLBACK . '=' . urlencode($callbak_url);
        $resource_request = $this->resource_base . $this->resource_uri . $querystring;
        //$resource_request = 'http://stage-api.myspace.com' . $this->resource_uri . $querystring;
        return $resource_request;
    }
}
?>