<?php

add_action("admin_menu", "createBookingMenu");

function createBookingMenu()
{
    add_menu_page("Car Booking", "Car Booking", 0, "car-booking-list", "adminBookinListFunction", "dashicons-schedule", 5);
    add_submenu_page("car-booking-list", "Add Booking", "Add Booking", 0, "add-booking", "adminAddBookingFunction");
    add_submenu_page("car-booking-list", "Setting", "Setting", 0, "booking-setting", "adminBookingSettingFunction");
}
function adminBookinListFunction()

{
    global $wpdb;
    $car_booking_table = $wpdb->prefix . 'car_booking';
    $avatar_image = plugin_dir_url(__FILE__) . 'assets/images/avatar.jpeg'; ?>
    <div class="table-wrapper paradise-admin-table">
        <h4 class="upcoming-rides">Upcoming rides </h4>
        <table class="paradise-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Date start</th>
                    <th>Date End</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>No of Travellers </th>
                    <th>Driver Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $upcoming_rides = $wpdb->get_results($wpdb->prepare("SELECT * FROM $car_booking_table WHERE status=%s AND DATE(date_to)>NOW() ORDER BY id desc", 'booking'));
                if ($upcoming_rides) {
                    foreach ($upcoming_rides as $upcoming_ride) {
                        $driver_id = $upcoming_ride->assigned_user;
                        $customer_id = $upcoming_ride->user_id; ?>
                        <tr>
                            <td>
                                <?php
                                $customer_details = get_userdata($customer_id);
                                // var_dump($user_details);
                                // $customer_image = get_avatar_url($customer_id);
                                $customer_phone_number = get_user_meta($customer_id, 'phone_number', true);

                                $custmoer_profile_id = get_user_meta($customer_id, 'profile_image_id', true);
                                $customer_profile = wp_get_attachment_url($custmoer_profile_id); ?>
                                <img src="<?php echo $customer_profile ? $customer_profile : $avatar_image ?>" alt="customer" />
                                <div class="admin_customer_details">
                                    <span><?php echo $customer_details->display_name; ?> </span><span>
                                        <?php echo $customer_phone_number ?></span>
                                </div>
                            </td>
                            <td><?php echo $upcoming_ride->date_from; ?></td>
                            <td><?php echo $upcoming_ride->date_to; ?></td>
                            <td><?php echo $upcoming_ride->source; ?></td>
                            <td><?php echo $upcoming_ride->destination; ?></td>
                            <td><?php echo $upcoming_ride->no_of_travellers; ?> </td>
                            <td>
                                <?php
                                $driver_details = get_userdata($driver_id);
                                // var_dump($user_details);
                                // $driver_image = get_avatar_url($driver_id);
                                $driver_phone_number = get_user_meta($driver_id, 'phone_number', true);
                                $driver_profile_id = get_user_meta($driver_id, 'profile_image_id', true);
                                $driver_profile = wp_get_attachment_url($driver_profile_id); ?>
                                <img src="<?php echo $driver_profile ? $driver_profile : $avatar_image ?>" alt="customer" />
                                <div class="admin_customer_details">
                                    <span><?php echo $driver_details->display_name; ?> </span><span>
                                        <?php echo $driver_phone_number ?></span>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>';
                    echo '<td> <h5> No data found. </h5></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-wrapper paradise-admin-table">
        <h4 class="completed_rides">Completed Rides</h4>
        <table class="paradise-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Date start</th>
                    <th>Date End</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>No of Travellers </th>
                    <th>Driver Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $completed_rides = $wpdb->get_results($wpdb->prepare("SELECT * FROM $car_booking_table WHERE status=%s AND DATE(date_to)<NOW() ORDER BY id desc", 'booking'));
                if ($completed_rides) {
                    foreach ($completed_rides as $completed_ride) {
                        $driver_id = $completed_ride->assigned_user;
                        $customer_id = $completed_ride->user_id; ?>
                        <tr>
                            <td>
                                <?php
                                $customer_details = get_userdata($customer_id);
                                $customer_phone_number = get_user_meta($customer_id, 'phone_number', true);
                                $custmoer_profile_id = get_user_meta($customer_id, 'profile_image_id', true);
                                $customer_profile = wp_get_attachment_url($custmoer_profile_id); ?>
                                <img src="<?php echo $customer_profile ? $customer_profile : $avatar_image ?>" alt="customer" />
                                <div class="admin_customer_details"> <span><?php echo $customer_details->display_name; ?>
                                    </span><span>
                                        <?php echo $customer_phone_number ?></span>
                                </div>
                            </td>
                            <td><?php echo $completed_ride->date_from; ?></td>
                            <td><?php echo $completed_ride->date_to; ?></td>
                            <td><?php echo $completed_ride->source; ?></td>
                            <td><?php echo $completed_ride->destination; ?></td>
                            <td><?php echo $completed_ride->no_of_travellers; ?> </td>
                            <td>
                                <?php
                                $driver_details = get_userdata($driver_id);
                                $driver_phone_number = get_user_meta($driver_id, 'phone_number', true);
                                $driver_profile_id = get_user_meta($driver_id, 'profile_image_id', true);
                                $driver_profile = wp_get_attachment_url($driver_profile_id); ?>
                                <img src="<?php echo $driver_profile ? $driver_profile : $avatar_image ?>" alt="customer" />
                                <div class="admin_customer_details">
                                    <span><?php echo $driver_details->display_name; ?> </span><span>
                                        <?php echo $driver_phone_number ?></span>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr>';
                    echo '<td><h5> No data found. </h5></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php }

function adminBookingSettingFunction()
{ ?>
    <div class="container" data-ng-app="myApp" data-ng-controller="myCtrl">
        <h2>Documentation</h2>
        <div class="booking-info">

            <section class="accordion">
                <input type="checkbox" name="collapse2" id="handle2"  checked="checked">
                <h2 class="handle">
                    <label for="handle2">1. Install Plugin</label>
                </h2>
                <div class="content">
                    <ul>
                        <ol>
                            <strong>- Go to your WordPress dashboard.</strong>
                        </ol>
                        <ol>
                            <strong>- Navigate to Plugins > Add New Plugin.</strong>
                        </ol>
                        <ol>
                            <strong>- Activate the Plugin.</strong>
                        </ol>
                    </ul>
                </div>
            </section>
            <section class="accordion">
                <input type="checkbox" name="collapse" id="handle1">
                <h2 class="handle">
                    <label for="handle1">2. Create a New Page</label>
                </h2>
                <div class="content">
                    <ul>
                        <ol>
                            <strong>- Go to your WordPress dashboard.</strong>
                        </ol>
                        <ol>
                            <strong>- Navigate to Pages > Add New.</strong>
                        </ol>
                        <ol>
                            <strong>- Title the page appropriately, such as "Driver Calendar" or "Blocked Dates".</strong>
                        </ol>
                        <ol>
                            <strong>- Add the content as [driver-calender] and publish the page.</strong>
                        </ol>
                    </ul>
                </div>
            </section>
        </div>
        <br><br>
        <div class="pts-wrapper">
            <table class="booking-setting-table">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
                <!-- <tr data-ng-repeat="customer in people | filter: table">
                    <td>Shortcode for User</td>
                    <td>[paradise-date-picker-user]</td>
                </tr> -->
                <tr data-ng-repeat="customer in people | filter: table">
                    <td>Shortcode for Driver</td>
                    <td>[driver-calender]</td>
                </tr>
                <tr data-ng-repeat="customer in people | filter: table">
                    <td>Shortcode for Driver Registraion</td>
                    <td>[driver-registration]</td>
                </tr>
            </table>
        </div>
    </div>
    <?php

    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'booking_setting'), 'updated');
    }

    // show error/update messages
    settings_errors('wporg_messages');
    ?>
    <div class="wrap">
        <form action="options.php" method="post">
            <?php
            settings_fields('booking_setting_group_name');
            do_settings_sections('booking_setting');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}

function adminAddBookingFunction()
{
    if (isset($_POST['admin_booking_button'])) {

        global $wpdb;
        $table = $wpdb->prefix . 'car_booking';
        $user_email = sanitize_email($_POST['user_email']);
        $date_range = sanitize_text_field($_POST['admin_daterange']);
        $source = sanitize_text_field($_POST['admin_location_from']);
        $destination = sanitize_text_field($_POST['admin_location_to']);
        $no_of_travellers = $_POST['admin_no_of_travellers'];

        if ($user_email == '' || $date_range == '' || $source == '' || $destination == '' || $no_of_travellers == '') {
            echo "Fields cannot be empty";
            return;
        }
        $date_range_explode = explode('-', $date_range);
        $starting_date_create = date_create($date_range_explode[0]);
        $ending_date_create = date_create($date_range_explode[1]);

        $starting_date = date_format($starting_date_create, "Y-m-d H:i:s");
        $ending_date = date_format($ending_date_create, "Y-m-d H:i:s");

        $customer_id = '';
        $user = get_user_by('email', $user_email); // checking if email address already exist
        if (!$user) {
            $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
            $user_id = wp_create_user($user_email, $random_password, $user_email); // creating new user
            if (is_wp_error($user_id)) {
                // examine the error message
                echo ("Error: " . $user_id->get_error_message());
                exit;
            } else {
                $customer_id = $user_id;
            }
        } else {
            $customer_id = $user->ID;
        }
        $date_range = array();

        // date rand implode gareko random id ko lagi block garna lai
        $starting_date_without_time = date("Y-m-d", strtotime($starting_date));
        $endiing_date_without_time = date("Y-m-d", strtotime($ending_date));

        $current_date = strtotime($starting_date_without_time);
        $end_timestamp = strtotime($endiing_date_without_time);

        $available_drivers = paradise_get_avilable_driver($starting_date_without_time, $endiing_date_without_time); // used for getting available drivers
        if (($key = array_search($customer_id, $available_drivers)) !== false) {
            unset($available_drivers[$key]); // removing current user from available drivers
        }
        if (!$available_drivers) {
            echo 'Drivers are currently unavailable. Please try again later.';
            return;
        }

        $random_key = array_rand($available_drivers);
        $random_id = $available_drivers[$random_key];

        // random id ko block date haru get gareko

        $bookings = $wpdb->get_results("SELECT `blocked_date` FROM $table WHERE `status` = 'booking' AND `user_id` = $random_id");

        while ($current_date <= $end_timestamp) {
            $date_range[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }
        $concat_ids = implode(', ', $date_range);

        // check random id table ma xa ki xaina vanera
        // added status and chaged id to user_id 
        $sql = $wpdb->prepare("SELECT * FROM $table WHERE user_id = %d and status= %s", $random_id, 'block');
        $result = $wpdb->get_results($sql);

        if (empty($bookings[0]->{'blocked_date'})) {

            // random user lai assign garera date booking garxa
            $assigned = array('user_id' => $customer_id, 'date_from' => $starting_date, 'date_to' => $ending_date, 'assigned_user' => $random_id, 'source' => $source, 'destination' => $destination, 'no_of_travellers' => $no_of_travellers, 'status' => 'booking');
            $assigned_format = array('%d', '%s', '%s', '%d', '%s', '%s', '%d', '%s');
            $wpdb->insert($table, $assigned, $assigned_format);
            // if user alerady database ma xa vane random id ko block date update garxa natra insert garxa
            // if ($result) {
            //     $add_block_id = $wpdb->get_results("UPDATE $table SET `blocked_date` = CONCAT(blocked_date, ', $concat_ids') WHERE `user_id` = $random_id");
            // } else {
            $data = array('user_id' => $random_id, 'blocked_date' => $concat_ids, 'status' => 'block');
            $format = array('%d', '%s', '%s');
            $wpdb->insert($table, $data, $format);
            // }
        }
        // Redirect or show a success message

    } ?>
    <div class="pts_admin_wrapper">
        <h2>Add Booking</h2>
        <form id="admin_user_date_destination" method="post">
            <div class="booking_details">
                <div class="booking-msg"></div>
                <div class="form-group">
                    <label for="admin_daterange">User Email</label>
                    <input type="email" name="user_email" class="admin_booking_email" placeholder="example@gmail.com" value="" />
                </div>
                <div class="form-group">
                    <label for="admin_daterange">Date:</label>
                    <input type="text" name="admin_daterange" class="admin_booking_date_range" value="" />
                </div>
                <div class="form-group">
                    <label for="location-from">Source</label>
                    <input type="text" name="admin_location_from" class="admin_booking_source" placeholder="From" />
                </div>
                <div class="form-group">
                    <label for="location-to">Destination</label>
                    <input type="text" name="admin_location_to" class="admin_booking_destination" placeholder="To" />
                </div>
                <div class="form-group">
                    <label for="number_of_travellers">Number of Travellers</label>
                    <input type="number" name="admin_no_of_travellers" class="admin_booking_no_of_travellers" value="" />
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="components-button is-primary" name="admin_booking_button" value="Submit">
            </div>

        </form>
    </div>

    <?php
}

add_action('user_new_form', 'userRoleDriverForm'); // creating a new user
function userRoleDriverForm()
{
    $role = $_GET['role'] ?? '';
    if ($role === 'driver') {
    ?>
        <script>
            jQuery(document).ready(function() {
                jQuery("#role option[value='driver']").prop("selected", true);
            });
        </script>
    <?php
    }
}


/**
 * Adds a submenu page under a custom post type parent.
 */
function register_sub_menu_users()
{
    add_submenu_page(
        'users.php',
        __('Driver List', 'driver-registration'),
        __('Driver List', 'driver-registration'),
        'manage_options',
        'driver-list',
        'admin_driver_list_page'
    );
}
add_action('admin_menu', 'register_sub_menu_users');
/**
 * Display callback for the submenu page.
 */
function admin_driver_list_page()
{
    $args = array(
        'role'    => 'driver',
        'orderby' => 'user_nicename',
        'order'   => 'ASC'
    );
    $users = get_users($args); ?>
    <div class="wrap">
        <div class="add-user-wrapper">
            <h1><?php _e('Driver List Table Here', 'driver-registration'); ?></h1>
            <a href="/wp-admin/user-new.php?role=driver" class="page-title-action">Add Driver</a>
        </div>
        <table class="driver-lists-table">
            <tr>
                <th id="d-username">Username</th>
                <th id="d-name">Name</th>
                <th id="d-email">Email</th>
            </tr>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td class="username">
                        <img src="https://secure.gravatar.com/avatar/e15bf56b19c53bb5573233589f74f8d7?s=32&d=mm&r=g" alt="">
                        <span><a href="<?php echo get_edit_user_link($user->ID); ?>"> <?php echo esc_html($user->user_nicename); ?></a>
                            <div class="driver-row-actions">
                                <span class="edit">
                                    <a href="<?php echo get_edit_user_link($user->ID); ?>" target="_blank">Edit</a>
                                </span>
                            </div>
                        </span>

                    </td>
                    <td class="name"><?php echo esc_html($user->display_name); ?></td>
                    <td class="email"><?php echo esc_html($user->user_email); ?></td>
                </tr>
            <?php } ?>
        </table>

    </div>
<?php
}



/**
 * custom option and settings
 */
function car_booking_settings_init()
{
    // Register a new setting for "wporg" page.
    register_setting('booking_setting_group_name', 'booking_setting_options');

    // Register a new section in the "wporg" page.
    add_settings_section(
        'booking_setting_id',
        __('Set The Page For Driver', 'paradise-car-booking'),
        'booking_setting_callback',
        'booking_setting'
    );

    add_settings_field(
        'booking_setting_field_id',
        __('Select page', 'paradise-car-booking'),
        'booking_field_callback',
        'booking_setting',
        'booking_setting_id'
    );
}

/**
 * Register our car_booking_settings_init to the admin_init action hook.
 */
add_action('admin_init', 'car_booking_settings_init');


function booking_setting_callback($args)
{
?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Select the page for driver calender', 'wporg'); ?></p>
<?php
}

function booking_field_callback()
{
    $pages = get_pages();
    $booking_settings = get_option('booking_setting_options');
    $saved_p = isset($booking_settings['page']) ? $booking_settings['page'] : ''; ?>
    <select class="selected_page" name="booking_setting_options[page]">
        <?php foreach ($pages as $page) {
            $current_page = home_url() . '/' . $page->post_name; ?>
            <option value="<?php echo  $current_page; ?>" <?php selected($saved_p, $current_page); ?>> <?php echo $page->post_title; ?></option>
        <?php } ?>
    </select>
<?php }
