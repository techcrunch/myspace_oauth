<?php

require_once("lib/base/Common.php");
require_once("lib/base/OAuthBaseAPI.php");

class PeopleAPI extends OAuthBaseAPI {
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
    
    //NOT SUPPORTED YET
    public function get_people_all($user_id) {
        $resource = sprintf("/v2/people/%s/%s", $user_id, SelectorType::$ALL);
        $result = $this->do_get($resource, null);
        return $result;
    }
    
    //OK //fields + startIndex + count
    public function get_people_friends($user_id, $query_parameters = null) {
        $resource = sprintf("/v2/people/%s/%s", $user_id, SelectorType::$FRIENDS);
        $result = $this->do_get($resource, null, $query_parameters);
        return $result;
    }

    //OK
    public function get_people_friends_current($query_parameters = null) {
        $resource = sprintf("/v2/people/%s/%s", SelectorType::$ME, SelectorType::$FRIENDS);
        $result = $this->do_get($resource, null, $query_parameters);
        return $result;
    }
    
    //NOT SUPPORTED YET
    public function get_people_by_group($user_id, $group_id) {
        $resource = sprintf("/v2/people/%s/%s", $user_id, $group_id);
        $result = $this->do_get($resource, null);
        return $result;
    }

    //NOT SUPPORTED YET
    public function get_people_by_pid($user_id, $pid) {
        $resource = sprintf("/v2/people/%s/%s/%s", $user_id, SelectorType::$ALL, $pid);
        $result = $this->do_get($resource, null);
        return $result;
    }
    
    //OK //fields + startIndex + count
    public function get_people_profile($user_id, $query_parameters = null) {
        $resource = sprintf("/v2/people/%s/%s", $user_id, SelectorType::$SELF);
        $result = $this->do_get($resource, null, $query_parameters);
        return $result;
    }
    
    //OK
    public function get_people_profile_current($query_parameters = null) {
        $resource = sprintf("/v2/people/%s/%s", SelectorType::$ME, SelectorType::$SELF);
        $result = $this->do_get($resource, null, $query_parameters);
        return $result;
    }

}
?>