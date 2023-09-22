<?php
class Zyble_API_Handler
{
    private $api_key;
    private $api_url = 'https://api.zyble.io/v1/view/tools';

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function fetch_tools($per_page, $current_page, $pricing)
    {

        $api_url = $this->api_url . '?apikey=' . urlencode($this->api_key) . '&sort_by=latest&per_page=' . $per_page . '&page=' . $current_page;
        $api_url = ( isset($pricing) ) ? $api_url . '&pricing=' . $pricing : $api_url; ## If pricing is set
        
        $response = wp_remote_get($api_url);

        if (!is_wp_error($response) && $response['response']['code'] === 200) {
            return json_decode(wp_remote_retrieve_body($response), true);
        } else {
            return array();
        }
    }

}
