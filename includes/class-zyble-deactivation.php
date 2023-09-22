<?php
class Zyble_Deactivation
{
    public static function deactivate()
    {
        // Clear cache rules when the plugin is deactivated
        self::clear_cache_rules();
        flush_rewrite_rules(); 
    }

    private static function clear_cache_rules()
    {
        // Clear transients used for caching API responses
        global $wpdb;
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_zyble_api_response_%'");
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_zyble_api_response_%'");
    }
}
