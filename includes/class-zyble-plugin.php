<?php
class Zyble_Plugin
{
    private $api_handler;

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'ai_tools_enqueue_scripts'));
        add_shortcode('ai_tools', array($this, 'ai_tools_shortcode'));

        add_action('wp_ajax_ai_tools_load_more', array($this, 'ai_tools_load_more'));
        add_action('wp_ajax_nopriv_ai_tools_load_more', array($this, 'ai_tools_load_more'));

        $api_key = get_option('zyble_api_key');
        $this->api_handler = new Zyble_API_Handler($api_key);
    }

    public function ai_tools_enqueue_scripts()
    {
        wp_enqueue_script('ai-tools-load-more', plugin_dir_url(__FILE__) . 'js/load-more.js', array('jquery'), '1.0', true);
        wp_localize_script('ai-tools-load-more', 'ai_tools_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function ai_tools_shortcode($atts)
    {

        // Default value for per_page
        $atts = shortcode_atts(
            array(
                'per_page' => 12,
                'style' => 'card',
                'show_categories' => 'yes',
                'show_load_more' => 'yes',
                'pricing' => ''
            ),
            $atts
        );

        $style = $atts['style'];
        $per_page = absint($atts['per_page']);
        $showcat = $atts['show_categories'];
        $pricing = $atts['pricing'];
        $show_load_more = $atts['show_load_more'];

        // Get the current page from the URL parameter
        $current_page = (isset($_GET['ai_tools_page']) && is_numeric($_GET['ai_tools_page'])) ? absint($_GET['ai_tools_page']) : 1;

        // Check is pricing is set and is correct
        $cache_key = 'zyble_api_response_' . (isset($pricing) && in_array(strtolower($pricing), array('free', 'paid', 'freemium')) ? strtolower($pricing) . '_' : '');
        
        // Load the cached API response if available for the current page
        $cache_key = $cache_key . $per_page . '_page_' . $current_page;
        if (false === ($api_response = get_transient($cache_key))) {
            // If not cached, make the API request and cache the response for 24 hours
            $api_data = $this->api_handler->fetch_tools($per_page, $current_page, $pricing);
            $api_response = json_encode($api_data);
            set_transient($cache_key, $api_response, 24 * HOUR_IN_SECONDS);
        }

        $api_data = json_decode($api_response, true);
        $total_tools = $api_data['total'];

        // Calculate total pages for pagination
        $total_pages = ceil($total_tools / $per_page);

        if (!empty($api_data['tools'])) {
            // Choose the template based on the style attribute
            $template_file = plugin_dir_path(__FILE__) . 'styles/' . $style . '-template.php';

            if (file_exists($template_file)) {
                ob_start();
                include $template_file;
                $output = ob_get_clean();
                return $output;
            } else {
                return 'Invalid style specified.';
            }
        } else {
            return 'no tool found';
        }

    }

    function ai_tools_load_more()
    {
        $atts = shortcode_atts(
            array(
                'per_page' => 12,
            ),
            $_POST
        );

        $current_page = absint($_POST['page']);
        $per_page = absint($atts['per_page']);
        $style = $_POST['style'];
        $showcat = $_POST['showcat'];
        $pricing = $_POST['pricing'];

        // Check is pricing is set and is correct
        $cache_key = 'zyble_api_response_' . (isset($pricing) && in_array(strtolower($pricing), array('free', 'paid', 'freemium')) ? strtolower($pricing) . '_' : '');

        // Load the cached API response if available for the current page
        $cache_key = $cache_key . $per_page . '_page_' . $current_page;
        if (false === ($api_response = get_transient($cache_key))) {
            // If not cached, make the API request and cache the response for 24 hours
            $api_data = $this->api_handler->fetch_tools($per_page, $current_page, $pricing);
            $api_response = json_encode($api_data);
            set_transient($cache_key, $api_response, 24 * HOUR_IN_SECONDS);
        }

        $api_data = json_decode($api_response, true);
        if (!empty($api_data['tools'])) {

            $template_file = plugin_dir_path(__FILE__) . 'styles/' . $style . '-template.php';

            if (file_exists($template_file)) {
                ob_start();
                include $template_file;
                $output = ob_get_clean();
                echo $output;
            }
        }

        die();
    }


}