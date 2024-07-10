<?php
/**
 * addin driver as a role
 */

function paradise_add_driver_role()
{
    if (!get_role('driver')) {
        add_role(
            'driver',
            __('Driver', 'paradise-car-booking'),
            array(
                'read'         => true,
                'edit_posts'   => false,
                'delete_posts' => false,

            )
        );
    }
}
add_action('init', 'paradise_add_driver_role');

/**
 * enqueue all the file
 */
require CAR_BOOKING_PLUGIN_DIR . 'includes/enqueue-file.php';
require CAR_BOOKING_PLUGIN_DIR . 'includes/driver-register-page.php';
require CAR_BOOKING_PLUGIN_DIR . 'includes/add-tab-on-dashboard.php';
