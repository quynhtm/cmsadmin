<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Custom Elasticsearch Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the Elasticsearch client.
    | See configuration options here:
    |
    | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
    */

    'config' => [
        'hosts'     => [env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')],
        'retries'   => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Index Name
    |--------------------------------------------------------------------------
    |
    | This is the index name that Elasticquent will use for all
    | Elasticquent models.
    */

    'default_index' => 'my_custom_index_name',

    'elasticsearch_on' => env('ELASTICSEARCH_ON', 0),
    
    'timeout' => env('ELASTICSEARCH_TIMEOUT', 3)
);
