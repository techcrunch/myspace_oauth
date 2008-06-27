<?php

require_once("lib/base/Common.php");
require_once("lib/base/OAuth.php");
require_once("lib/base/BaseAPI.php");

class OAuthBaseAPI extends BaseAPI {
    protected $oauth_token = null;
    protected $oauth_token_secret = null;
    protected $oauth_consumer = "";
    
    protected $application_key = "";
    protected $application_secret = "";
    
    //ctor
    public function __construct($application_key, $application_secret) {
        $this->application_key = $application_key;
        $this->application_secret = $application_secret;
        
        $this->oauth_consumer = new OAuthConsumer($this->application_key, $this->application_secret);
        $this->oauth_token = '';//new OAuthToken(null, null);
        
        $this->api_version = ApiVersionType::$VERSION_V2;
        
        $this->resource_base = CommonConstants::$URL_ROOT_API;
        $this->response_type = ResponseType::$JSON;
    }
    
    public function do_get_raw($resource, $headers) {
        $this->resource_uri = $resource;
        $sha1 = new OAuthSignatureMethod_HMAC_SHA1();
        
        $token = new OAuthToken($this->oauth_token, $this->oauth_token_secret);
        $req = OAuthRequest::from_consumer_and_token($this->oauth_consumer, $token, HttpMethodType::$GET, $this->resource_base . $this->resource_uri, $headers);        
        $req->sign_request($sha1, $this->oauth_consumer, $token);        
        $resource_request = $req->to_url();
        
        $output = $this->output_array;
        
        $this->output_array = false;            
        $result = parent::_do_get($resource_request, $headers);
        
        $this->output_array = $output;
        return $result;
    }
    
    //public function a_get($resouce, $headers = null, $query_parameters = null) {
    //    $request = new OAuthRequest(HttpMethodType::$GET, $resouce, $headers);
    //    $sha1 = new OAuthSignatureMethod_HMAC_SHA1();
    //}
    
    public function do_get($resource, $headers = null, $query_parameters = null) {
        $this->resource_uri = $resource;
        
        $sha1 = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthToken($this->oauth_token, $this->oauth_token_secret);
        
        $req = OAuthRequest::from_consumer_and_token($this->oauth_consumer, $token, HttpMethodType::$GET, $this->resource_base . $this->resource_uri, $headers);
        $req->set_parameter(QueryType::$FORMAT, $this->response_type);
        
        if (isset($query_parameters) && $query_parameters != null) {
            if ($query_parameters->format != null) {
                $req->set_parameter(QueryType::$FORMAT, $query_parameters->format);
            }
            
            if ($query_parameters->fields != null) {
                $req->set_parameter(QueryType::$FIELDS, $query_parameters->fields);
            }
            
            if ($query_parameters->count != null) {
                $req->set_parameter(QueryType::$COUNT, $query_parameters->count);
            }
            
            if ($query_parameters->index_by != null) {
                $req->set_parameter(QueryType::$INDEX_BY, $query_parameters->index_by);
            }
            
            if ($query_parameters->network_distance != null) {
                $req->set_parameter(QueryType::$NETWORK_DISTANCE, $query_parameters->network_distance);
            }
            
            if ($query_parameters->order_by != null) {
                $req->set_parameter(QueryType::$ORDER_BY, $query_parameters->order_by);
            }            
            
            if ($query_parameters->start_index != null) {
                $req->set_parameter(QueryType::$START_INDEX, $query_parameters->start_index);
            }            
        }
        
        $req->sign_request($sha1, $this->oauth_consumer, $token);
        $resource_request = $req->to_url();
        
        return parent::_do_get($resource_request, $headers);
    }
    
    public function do_post($resource, $post_data, $headers) {
        $this->resource_uri = $resource;
        $sha1 = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthToken($this->oauth_token, $this->oauth_token_secret);
        $req = OAuthRequest::from_consumer_and_token($this->oauth_consumer, $token, HttpMethodType::$GET, $this->resource_base . $this->resource_uri, $headers);
        $req->set_parameter(QueryType::$FORMAT, $this->response_type);
        $req->sign_request($sha1, $this->oauth_consumer, $token);
        $resource_request = $req->to_url();
        return parent::_do_post($resource_request, $post_data, $headers);
    }

    public function do_put($resource, $put_data, $headers) {
        $this->resource_uri = $resource;
        $sha1 = new OAuthSignatureMethod_HMAC_SHA1();
        $token = new OAuthToken($this->oauth_token, $this->oauth_token_secret);
        $req = OAuthRequest::from_consumer_and_token($this->oauth_consumer, $token, HttpMethodType::$GET, $this->resource_base . $this->resource_uri, $headers);
        $req->set_parameter(QueryType::$FORMAT, $this->response_type);
        $req->sign_request($sha1, $this->oauth_consumer, $token);
        $resource_request = $req->to_url();
        return parent::_do_put($resource_request, $put_data, $headers);
    }
    
    public function set_oauth_token($oauth_token) {
    	$this->oauth_token = $oauth_token;
    }
    
    public function set_oauth_token_secret($oauth_token_secret) {
    	$this->oauth_token_secret = $oauth_token_secret;
    }
}
?>