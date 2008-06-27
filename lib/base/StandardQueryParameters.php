<?php

class QueryType {
    public static $FORMAT = "format";
    public static $FIELDS = "fields";
    public static $START_INDEX = "startIndex";
    public static $COUNT = "count";
    public static $NETWORK_DISTANCE = "networkDistance";
    public static $INDEX_BY = "indexBy";
    public static $ORDER_BY = "orderBy";    
}

class StandardQueryParameters {
    public $format = null;
    public $fields = null;
    public $start_index = null;
    public $count = null;
    public $network_distance = null;
    public $index_by = null;
    public $order_by = null;
    
    public function __construct($format = null, $fields = null, $startIndex = null, $count = null, $networkDistance = null, $indexBy = null, $orderBy = null) {
        $this->format = $format;
        $this->fields = $fields;
        $this->start_index = $startIndex;
        $this->count = $count;
        $this->network_distance = $networkDistance;
        $this->index_by = $indexBy;
        $this->order_by = $orderBy;
    }
}

?>