<?php
class Zyble_Settings
{
    public function init()
    {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page()
    {
        add_options_page('Zyble Settings', 'Zyble Settings', 'manage_options', 'zyble_plugin_settings', array($this, 'settings_page_content'));
    }

    public function register_settings()
    {
        register_setting('zyble_api_group', 'zyble_api_key');
    }

    public function settings_page_content()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Save the API key
        if (isset($_POST['submit'])) {
            $api_key = sanitize_text_field($_POST['api_key']);
            update_option('zyble_api_key', $api_key);
        }

        // Purge the cache
        if (isset($_POST['purge_cache'])) {
            $this->purge_api_cache();
        }

        // Display the settings form
        ?>
        <div class="wrap">
            <h1>Zyble Plugin Settings</h1>
            <form method="post" action="">
                <?php settings_fields('zyble_api_group'); ?>
                <?php do_settings_sections('zyble_api_group'); ?>
                <label for="api_key">API Key:</label>
                <input type="text" name="api_key" id="api_key" value="<?php echo esc_attr(get_option('zyble_api_key')); ?>" class="regular-text">
                <p class="description">Enter your API key for accessing the Zyble API. Don't have an API key? <a href="https://zyble.io/" target="_blank">Get here</a></p>
                <p><code>[ai_tools]</code> add this shortcode to any page or post to show latest tools. Make sure you add the zyble's api first.</p>
                <?php submit_button('Save Settings'); ?>
            </form>

            <!-- Add the Purge Cache button -->
            <form method="post" action="">
                <?php wp_nonce_field('zyble_purge_cache'); ?>
                <input type="hidden" name="purge_cache" value="1">
                <?php submit_button('Purge API Response', 'secondary', 'purge_cache_button'); ?>
            </form>
        </div>
        <?php
    }

    // Purge the API cache
    private function purge_api_cache()
    {
        global $wpdb;
        $transient_name = 'zyble_api_response_'; // Modify this if needed
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '%_transient_$transient_name%' OR option_name LIKE '%_transient_timeout_$transient_name%'");
    }
}
