<?php
// Function to register custom rewrite rules
function my_plugin_rewrite_rules() {
    add_rewrite_rule('^drivers/?$', 'index.php?drivers=true', 'top');
    add_rewrite_rule('^driver/([^/]+)/?$', 'index.php?author_name=$matches[1]', 'top');
}
add_action('init', 'my_plugin_rewrite_rules');

// Function to add custom query vars
function my_plugin_query_vars($query_vars) {
    $query_vars[] = 'drivers';
    return $query_vars;
}
add_filter('query_vars', 'my_plugin_query_vars');

// Function to redirect to custom templates
function my_plugin_template_redirect() {
    $driver_id = get_query_var('driver_id');
    if (get_query_var('drivers') == 'true') {
        include plugin_dir_path(__FILE__) . '../templates/drivers-archive.php';
        exit;
    }
    if (is_author()) {
        include plugin_dir_path(__FILE__) . '../templates/single-driver.php';
        exit;
    }
}
add_action('template_redirect', 'my_plugin_template_redirect');

