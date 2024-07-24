<?php

/**
 * Plugin Name: Car Booking
 * Plugin URI: https://codepixelzmedia.com.np/
 * Description: Book your destination. 
 * Version: 1.0.0
 * Author: WhitelabelWP
 * Text Domain: paradise-car-booking
 * Author URI: https://codepixelzmedia.com.np/
 */

if (!defined('ABSPATH')) {
        exit;
};

define('CAR_BOOKING_PLUGIN_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, 'activate_car_booking_plugin');
// register_deactivation_hook(__FILE__, 'deactivate_car_booking_plugin');

require CAR_BOOKING_PLUGIN_DIR . 'includes/inc.php';
require CAR_BOOKING_PLUGIN_DIR . 'admin/car-booking-admin.php';
require CAR_BOOKING_PLUGIN_DIR . 'public/car-booking-public.php';
require CAR_BOOKING_PLUGIN_DIR . 'includes/author-page-rule.php';


/**
 * The function `activate_car_booking_plugin` creates a database table for car booking if it does not
 * already exist.
 */
function activate_car_booking_plugin()
{
        global $wpdb;
        $prefix = $wpdb->prefix;
        $table_name = $prefix . "car_booking";
        $charset_collate = $wpdb->get_charset_collate();
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                $sql = "CREATE TABLE " . $table_name . "(
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                user_id int(15) NOT NULL,
                date_from datetime NULL,
                date_to datetime NULL,
                assigned_user int(9) NULL,
                source varchar(255) NULL,
                destination varchar(255) NULL,
                no_of_travellers int(11) NULL,
                blocked_date varchar(255) NULL,
                status varchar(20) NOT NULL,
                block_type varchar(20) NULL,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY  (id)
                ) $charset_collate;";
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
        }

        my_plugin_rewrite_rules();
    flush_rewrite_rules();
}


/**
 * The function "deactivate_car_booking_plugin" drops a table named "car_booking" from the WordPress
 * database.
 */
function deactivate_car_booking_plugin()
{
        global $wpdb;
        $table_name = $wpdb->prefix . 'car_booking';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
}



add_shortcode('driver-calender', 'driver_calender');
function driver_calender()
{
        if (is_user_logged_in()) {
                $data_of_blocked_date_current_users = get_block_date_of_specific_user();
                $json_blocked_dates = json_encode($data_of_blocked_date_current_users); ?>
                <div id='calendar' data-blocked-date="<?php echo $json_blocked_dates; ?>"></div>
                <script>
                        jQuery(document).ready(function() {
                                var blockedDates = <?php echo $json_blocked_dates; ?>;
                                // FullCalendar
                                var calendarEl = jQuery("#calendar")[0];
                                var dates = jQuery("#calendar").data("blocked-date");
                                const events = [];
                                blockedDates.forEach(entry => {
                                        const dates = entry.blocked_date.split(',').map(date => date.trim());
                                        var source = entry.source != null ? 'Booked from ' + entry.source : "Booked";
                                        var destination = entry.destination != null ? ' to ' + entry.destination : "";

                                        // Parse the last date in the array and add one day to it
                                        let lastDate = new Date(dates[dates.length - 1]);
                                        lastDate.setDate(lastDate.getDate() + 1);
                                        let endDate = lastDate.toISOString().split('T')[0];
                                        events.push({
                                                // title: entry.block_type === 'self' ? 'self blocked' : source + destination, //uncomment for title
                                                start: dates[0],
                                                end: endDate,
                                                display: 'background', //comment to title
                                                color: '#df0606', //comment for title
                                                // color: entry.block_type === 'self' ? '#df0606' : '#409560', //uncomment for title
                                        });
                                });

                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                        // headerToolbar: {
                                        //         left: 'prev,next today',
                                        //         center: 'title',
                                        //         right: 'dayGridMonth,timeGridWeek'
                                        // },
                                        headerToolbar: {
                                                left: "prev,next today",
                                                center: "title",
                                                right: "dayGridMonth",
                                        },
                                        initialDate: new Date(),
                                        events: events,
                                        // backgroundColor: 'red'
                                });

                                calendar.render();
                        });
                </script>
<?php
        }
}
