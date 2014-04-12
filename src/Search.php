<?php

/**
 * Provides access to our JSON search API
 *
 * Built for PHPNE14 Full Text Demo
 *
 * @author Tom Walder <tom@docnet.nu>
 */
class Search
{

    /**
     * Base URL for our Python search endpoint
     */
    const BASE_SEARCH_URL = 'http://search.phpne14.appspot.com';

    /**
     * Create a document in the search index
     *
     * Expect the response to be JSON
     *
     * @param string $str_title
     * @param string $str_contents
     * @return stdClass
     */
    public function createDoc($str_title, $str_contents)
    {
        return json_decode($this->httpPost(self::BASE_SEARCH_URL . '/create', [
            'title' => $str_title,
            'contents' => $str_contents,
            'created' => time()
        ]));
    }

    /**
     * Run a search query
     *
     * Expect the response to be JSON
     *
     * @param string $str_phrase
     * @return stdClass
     */
    public function query($str_phrase)
    {
        $str_response = $this->httpPost(self::BASE_SEARCH_URL . '/query', [
            'q' => $str_phrase
        ]);
        return json_decode($str_response);
    }

    /**
     * Execute an HTTP POST and return the output
     *
     * No cURL on Google App Engine
     *
     * @param string $str_endpoint
     * @param array $arr_data
     * @return string
     */
    protected function httpPost($str_endpoint, $arr_data)
    {
        $arr_opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($arr_data)
            ]
        ];
        $obj_context = stream_context_create($arr_opts);
        return file_get_contents($str_endpoint, FALSE, $obj_context);
    }

}