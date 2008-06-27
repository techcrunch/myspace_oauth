<?php

class CommonConstants {
    public static $LIB_NAME = "MySpace DataAvailability PHP";
    public static $LIB_VERSION = "v0.1.20080626";
    
    public static $URL_ROOT_API = "http://api.myspace.com";
    
    public static $X_HTTP_METHOD_OVERRIDE_HEADER = "X-HTTP-Method-Override";
}

class Configs {
    public static $APPLICATION_KEY = "api_oauth_consumer_key";
    public static $APPLICATION_SECRET = "api_oauth_consumer_secret";
}

class SelectorType {
    public static $ME = "@me";
    public static $ALL = "@all";
    public static $SELF = "@self";
    public static $FRIENDS = "@friends";
}

class ApiVersionType {
    public static $VERSION_V1 = "v1";
    public static $VERSION_V2 = "v2";
}

class ResponseType {
    public static $XML = "XML";
    public static $JSON = "JSON";
}

//---------------------------------------------------

class XmlNameSpaceList {
    public static $NS_API_V1 = "api-v1.myspace.com";
    public static $NS_XSI = "http://www.w3.org/2001/XMLSchema-instance";
    public static $NS_XSD = "http://www.w3.org/2001/XMLSchema";
}

class SurfaceType {
    public static $CANVAS = "canvas";
    public static $HOME = "home";
    public static $PROFILE_LEFT = "profile.left";
    public static $PROFILE_RIGHT = "profile.right";
}

class HttpMethodType {
    public static $GET = "GET";
    public static $POST = "POST";
    public static $PUT = "PUT";
    public static $DELETE = "DELETE";
}

// OAuth

class OAuthConstants {
    public static $OAUTH_TOKEN = "oauth_token";
    public static $OAUTH_TOKEN_SECRET = "oauth_token_secret";
    public static $QS_OAUTH_CALLBACK = "oauth_callback";
}
    
// OpenSocial Specific

class OpenSocialQueryStringList {
    public static $QS_OPEN_SOCIAL_TOKEN = "opensocial_token";
    public static $QS_OPEN_SOCIAL_VIEW = "opensocial_mode";
    public static $QS_DETAIL_TYPE = "detailtype";
}

class ContextType {
    public static $VIEWER = "VIEWER";
    public static $OWNER = "OWNER";
}

class DetailType {
    public static $DETAIL = "DETAIL";
    public static $BASIC = "BASIC";
    public static $FULL = "FULL";
}


?>