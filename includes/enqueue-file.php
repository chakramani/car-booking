<?php

/**
 * The function `paradice_booking_load_scripts` enqueues various scripts and styles for a booking
 * plugin in WordPress.
 */
function paradice_booking_load_scripts_public()
{
    wp_enqueue_media();
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
    wp_enqueue_script('fullcalender', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js', '', rand(), true);
    wp_enqueue_script('paradise-jquery', "https://cdn.jsdelivr.net/jquery/latest/jquery.min.js", array(), rand());
    wp_enqueue_script('paradise-moment', "https://cdn.jsdelivr.net/momentjs/latest/moment.min.js", array(), rand());
    wp_enqueue_script('paradise-datepicker-js', "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js", array(), rand());
    wp_enqueue_script('paradise-jquery-ui-js', "https://code.jquery.com/ui/1.9.2/jquery-ui.js", array(), rand());
    wp_enqueue_script('paradise-multi-datepicker-js', "https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js", array(), rand());
    wp_enqueue_script('paradise-public-main-js', plugin_dir_url(__FILE__) . '../public/js/main.js', array(), rand());
    wp_enqueue_style('paradise-datepicker-css', "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css", false, rand());
    wp_enqueue_style('paradise-style-css', plugin_dir_url(__FILE__) . '../public/css/style.css', false, rand());

    wp_localize_script('paradise-public-main-js', 'myajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'paradice_booking_load_scripts_public');


/**
 * The function `paradice_booking_load_scripts` enqueues various scripts and styles for a booking
 * plugin in WordPress.
 */
function paradice_booking_load_scripts_admin($hook)
{
    $screen = get_current_screen();
    // var_dump($screen);
    if (($screen->base === 'user-edit' && $screen->id === 'user-edit') || ( $screen->base === 'user' && $screen->id === 'user') || ($hook === 'car-booking_page_add-booking' )) {
        wp_enqueue_media();
        wp_enqueue_script('fullcalender', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js', '', rand(), true);
        wp_enqueue_script('paradise-jquery', "https://cdn.jsdelivr.net/jquery/latest/jquery.min.js", array(), rand());
        wp_enqueue_script('paradise-moment', "https://cdn.jsdelivr.net/momentjs/latest/moment.min.js", array(), rand());
        wp_enqueue_script('paradise-datepicker-js', "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js", array(), rand());
        wp_enqueue_script('paradise-jquery-ui-js', "https://code.jquery.com/ui/1.9.2/jquery-ui.js", array(), rand());
        wp_enqueue_script('paradise-multi-datepicker-js', "https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.js", array(), rand());
        wp_enqueue_script('paradise-fontawesome-js', "https://use.fontawesome.com/facf9fa52c.js", array(), rand());
        wp_enqueue_style('paradise-datepicker-css', "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css", false, rand());
        wp_enqueue_style('paradise-admin-style', plugin_dir_url(__FILE__) . '../admin/css/style.css', false, rand());
        wp_enqueue_script('paradise-admin-js', plugin_dir_url(__FILE__) . '../admin/js/main.js', array(), rand());
    }
}
add_action('admin_enqueue_scripts', 'paradice_booking_load_scripts_admin');
