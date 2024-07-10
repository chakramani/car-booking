<?php

function add_car_trip_tab_to_dashboard_menus($dashboard_menus)
{
    if (is_user_logged_in()) {
        // Get the current user's data
        $current_user = wp_get_current_user();
        if (in_array('driver', (array) $current_user->roles)) {
            $dashboard_menus['car-trip'] = array(
                'menu_title'      => __('My Trip', 'driver-registration'),
                'menu_class'      => 'lrf-car-trip',
                'menu_content_cb' => 'display_car_trip_tab_content',
                'priority'        => 50,
            );
            $dashboard_menus['car-trip-doc'] = array(
                'menu_title'      => __('Car Trip Documents', 'driver-registration'),
                'menu_class'      => 'lrf-car-trip-doc',
                'menu_content_cb' => 'display_car_trip_doc_tab_content',
                'priority'        => 50,
            );
            $dashboard_menus['car-book-block-date'] = array(
                'menu_title'      => __('Block date', 'driver-registration'),
                'menu_class'      => 'lrf-car-book-block-date',
                'menu_content_cb' => 'display_car_book_block_date',
                'priority'        => 50,
            );
        }
        if (!in_array('driver', (array) $current_user->roles)) {

            $dashboard_menus['car-trip-for-all'] = array(
                'menu_title'      => __('Car Trip', 'car-booking'),
                'menu_class'      => 'lrf-car-trip-for-all',
                'menu_content_cb' => 'display_car_trip_for_all_tab_content',
                'priority'        => 50,
            );
            $dashboard_menus['book-car'] = array(
                'menu_title'      => __('Car Booking', 'car-booking'),
                'menu_class'      => 'lrf-book-car',
                'menu_content_cb' => 'book_car_callback_function',
                'priority'        => 50,
            );
        }
    }
    return $dashboard_menus;
}
add_filter('wp_travel_engine_user_dashboard_menus', 'add_car_trip_tab_to_dashboard_menus');

function display_car_trip_tab_content()
{
    echo '<h2>' . __('My Trips', 'driver-registration') . '</h2>';

    if (is_user_logged_in()) {
        global $wpdb;
        $current_user_id = get_current_user_id();
        $user = get_userdata($current_user_id);
        $avatar_image = plugin_dir_url(__FILE__) . '../public/assets/images/avatar.jpeg';

        global $wpdb;
        $table = $wpdb->prefix . 'car_booking'; ?>
        <div class="driver-dashboard-front">

            <div class="table-wrapper paradise-driver-table">
                <?php
                $driver_upcoming_rides = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE assigned_user=%d AND status=%s AND DATE(date_to)>NOW() ORDER BY id desc", $current_user_id, 'booking'));
                ?>
                <h4 class="driver-upcoming-ride">Upcoming Rides </h4>
                <table class="paradise-table" id="pd-driver-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Date start</th>
                            <th>Date End</th>
                            <th>Source</th>
                            <th>Destination</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($driver_upcoming_rides) {
                            foreach ($driver_upcoming_rides as $driver_upcoming_ride) {
                        ?>
                                <tr>

                                    <td>
                                        <?php
                                        $user_id = $driver_upcoming_ride->user_id;
                                        $user_details = get_userdata($user_id);
                                        // var_dump($user_details);
                                        // $user_image = get_avatar_url($user_id);
                                        $phone_number = get_user_meta($user_id, 'phone_number', true);
                                        $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
                                        $profile_image_src = wp_get_attachment_url($profile_image_id);
                                        ?>

                                        <img src="<?php echo $profile_image_src ? $profile_image_src : $avatar_image; ?>" alt="driver" />
                                        <div class="driver_details">
                                            <span><?php echo $user_details->display_name; ?> </span><span>
                                                <?php echo $phone_number ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo $driver_upcoming_ride->date_from; ?></td>
                                    <td><?php echo $driver_upcoming_ride->date_to; ?></td>
                                    <td><?php echo $driver_upcoming_ride->source; ?></td>
                                    <td><?php echo $driver_upcoming_ride->destination; ?></td>

                                </tr>

                        <?php
                            }
                        } else {
                            echo '<tr>';
                            echo '<td>  No data found. </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-wrapper paradise-driver-table">
                <h4 class="driver-completed-ride">Completed Rides </h4>
                <?php
                $driver_completed_rides = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE assigned_user=%d AND status=%s AND DATE(date_to)<NOW() ORDER BY id desc", $current_user_id, 'booking'));
                ?>
                <table class="paradise-table" id="pd-driver-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Date start</th>
                            <th>Date End</th>
                            <th>Source</th>
                            <th>Destination</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($driver_completed_rides) {
                            foreach ($driver_completed_rides as $driver_completed_ride) {
                        ?>
                                <tr>

                                    <td>
                                        <?php
                                        $user_id = $driver_completed_ride->user_id;
                                        $user_details = get_userdata($user_id);
                                        // var_dump($user_details);
                                        // $user_image = get_avatar_url($user_id);
                                        $phone_number = get_user_meta($user_id, 'phone_number', true);
                                        $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
                                        $profile_image_src = wp_get_attachment_url($profile_image_id);
                                        ?>

                                        <img src="<?php echo $profile_image_src ? $profile_image_src : $avatar_image; ?>" alt="driver" />
                                        <div class="driver_details">
                                            <span><?php echo $user_details->display_name; ?> </span><span>
                                                <?php echo $phone_number ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo $driver_completed_ride->date_from; ?></td>
                                    <td><?php echo $driver_completed_ride->date_to; ?></td>
                                    <td><?php echo $driver_completed_ride->source; ?></td>
                                    <td><?php echo $driver_completed_ride->destination; ?></td>

                                </tr>

                        <?php
                            }
                        } else {
                            echo '<tr>';
                            echo '<td> No data found. </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php
    }
}
function display_car_trip_doc_tab_content()
{
    echo '<h2>' . __('Car Trips Docs', 'driver-registration') . '</h2>';
    $avatar_image = plugin_dir_url(__FILE__) . '../public/assets/images/avatar.jpeg';
    $car_placeholder_image = plugin_dir_url(__FILE__) . '../public/assets/images/car.png';
    $lisense_placeholder_image = plugin_dir_url(__FILE__) . '../public/assets/images/lisence-placeholder.png';
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        if (isset($_POST['update'])) {
            if (!empty($_FILES['update_driver_img']['name'])) {
                update_image($_FILES['update_driver_img'], 'profile_image_id', $user_id);
            }
            if (!empty($_FILES['update_car_img']['name'])) {
                update_image($_FILES['update_car_img'], 'car_image_id', $user_id);
            }
            if (!empty($_FILES['update_lisence_img']['name'])) {
                update_image($_FILES['update_lisence_img'], 'liscence', $user_id);
            }
            if (!empty($_POST['update_video'])) {
                update_user_meta($user_id, 'driver_video_url', sanitize_url($_POST['update_video']));
            }
            if (!empty($_FILES['update_doc1']['name'])) {
                update_image($_FILES['update_doc1'], 'other_doc1_id', $user_id);
            }
            if (!empty($_FILES['update_doc2']['name'])) {
                update_image($_FILES['update_doc2'], 'other_doc2_id', $user_id);
            }
        }

        $driver_image_id = get_user_meta($user_id, "profile_image_id", true);
        $car_image_id = get_user_meta($user_id, "car_image_id", true);
        $ps_video_url = get_user_meta($user_id, "driver_video_url", true);
        $liscence_id = get_user_meta($user_id, "liscence", true);
        $other_doc1_id = get_user_meta($user_id, "other_doc1_id", true);
        $other_doc2_id = get_user_meta($user_id, "other_doc2_id", true);

        $driver_image_url = get_attachment_url($driver_image_id);
        $car_image_url = get_attachment_url($car_image_id);
        // $video_url = get_attachment_url($ps_video_id);
        $liscence_url = get_attachment_url($liscence_id);
        $other_doc1_url = get_attachment_url($other_doc1_id);
        $other_doc2_url = get_attachment_url($other_doc2_id);
    }

    ?>
    <form method="post" enctype="multipart/form-data">

        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Driver Image</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <img src="<?php echo $driver_image_url ? $driver_image_url : $avatar_image; ?>" alt="driver-image">
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <!-- <button id="update_driver_image">Upload</button> -->
                <input type="file" name="update_driver_img" id="update_driver_img">
            </div>
        </div>
        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Car Image</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <img src="<?php echo $car_image_url ? $car_image_url : $car_placeholder_image; ?>" alt="car-image">
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <input type="file" name="update_car_img" id="update_car_img">
            </div>
        </div>
        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Lisence</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <img src="<?php echo $liscence_url ? $liscence_url : $lisense_placeholder_image; ?>" alt="liscence-image">
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <input type="file" name="update_lisence_img" id="update_lisence_img">
            </div>
        </div>
        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Video</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <iframe src="<?php echo $ps_video_url; ?>" id="my-video"> </iframe>
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <input type="url" name="update_video" id="update_video" placeholder="URL...">
            </div>
        </div>
        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Document1</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <img src="<?php echo $other_doc1_url ? $other_doc1_url : $lisense_placeholder_image; ?>" alt="doc1-image">
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <input type="file" name="update_doc1" id="update_doc1" accept=".pdf,.doc,.docx,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            </div>
        </div>
        <div class="row car-trip-doc">
            <div class="col-1 car-trip-col">
                <h5>Document2</h5>
            </div>
            <div class="col-2 car-trip-col">
                <div class="car-trip-image">
                    <img src="<?php echo $other_doc2_url ? $other_doc2_url : $lisense_placeholder_image; ?>" alt="doc2-image">
                </div>
            </div>
            <div class="col-3 car-trip-col">
                <input type="file" name="update_doc2" id="update_doc2" accept=".pdf,.doc,.docx,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
            </div>
        </div>

        <input type="submit" value="update" name="update">
    </form>

<?php

}
function get_attachment_url($attachment_id)
{
    $image_url = wp_get_attachment_url($attachment_id, true);
    return $image_url;
}


function update_image($file, $meta_key, $user_id)
{
    if (!empty($file['name'])) {
        $uploaded_file = $file;

        // Check for upload errors
        if ($uploaded_file['error'] != 0) {
            wp_die('There was an error uploading the image.');
        }

        // Use the WordPress function to handle file uploads
        $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
        if ($upload && !isset($upload['error'])) {


            // Get the path to the upload directory.
            $wp_upload_dir = wp_upload_dir();

            // Prepare an array of post data for the attachment.
            $attachment = array(
                'guid'           => $wp_upload_dir['url'] . '/' . basename($upload['file']),
                'post_mime_type' => $upload['type'],
                'post_title'     => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            // Insert the attachment.
            $attach_id = wp_insert_attachment($attachment, $upload['file']);


            if ($attach_id) {
                update_user_meta($user_id, $meta_key, $attach_id);
            } else {
                wp_die('Failed to create attachment.');
            }
        } else {
            wp_die($upload['error']);
        }
    } else {
        wp_die('No file was uploaded.');
    }
}



function display_car_book_block_date()
{
    global $wpdb;
    $table = $wpdb->prefix . 'car_booking';
    $current_user_id = get_current_user_id();
    echo '<h2>' . __('Block Dates', 'driver-registration') . '</h2>';

    if (isset($_POST['block_date'])) {
        $dateRange = $_POST['daterange_block'];
        list($startDate, $endDate) = explode(' - ', $dateRange);
        $dates = getDatesBetween($startDate, $endDate);

        $implode_date = implode(",", $dates);
        $data_of_blocked_date_current_users = get_block_date_of_specific_user();
        $data = array('user_id' => $current_user_id, 'blocked_date' => $implode_date, 'status' => 'block', 'block_type' => 'self');
        $format = array('%d', '%s', '%s', '%s');
        $wpdb->insert($table, $data, $format);
    }
    $data_of_blocked_date_current_users = get_block_date_of_specific_user();
    $json_blocked_dates = json_encode($data_of_blocked_date_current_users); 
    $booking_settings = get_option('booking_setting_options');?>
    <form method="post">
        <div class="form-group">
            <label for="daterange_block">Date:</label>
            <span class="dashicons dashicons-calendar"></span>
            <input type='text' name='daterange_block' class='block_date_range' id='block_date_range' value='' data-blocked-date='<?php echo $json_blocked_dates; ?>' />
        </div>

        <div class="block-date-buttons">
            <input type="submit" name="block_date" value="Block">
            <a href="<?php echo $booking_settings['page']; ?>" target="_blank" class="view-blocked-date">View Blocked Date</a>
        </div>
    </form>
    <?php
}


function getDatesBetween($startDate, $endDate, $format = 'Y-m-d')
{
    $interval = new DateInterval('P1D');
    $realEndDate = new DateTime($endDate);
    $realEndDate->add($interval);

    $period = new DatePeriod(new DateTime($startDate), $interval, $realEndDate);

    $dates = [];
    foreach ($period as $date) {
        $dates[] = $date->format($format);
    }

    return $dates;
}



function display_car_trip_for_all_tab_content()
{
    echo '<h2>' . __('Car Journey', 'car-booking') . '</h2>';
    if (is_user_logged_in()) {
        global $wpdb;
        $current_user_id = get_current_user_id();
        $table = $wpdb->prefix . 'car_booking';
        $avatar_image = plugin_dir_url(__FILE__) . '../public/assets/images/avatar.jpeg';
        $user_upcoming_rides = $wpdb->get_results("SELECT * FROM $table WHERE `status` = 'booking' AND `user_id` = $current_user_id AND DATE(date_to)>NOW() ORDER BY id desc"); ?>
        <!-- HTML code here -->
        <div class="customer-dashboard-front">
            <div class="table-wrapper paradise-customer-table">
                <h4 class="customer-upcoming-rides">Upcoming Journey</h4>
                <table class="paradise-table" id="pd-cust-table">
                    <thead>
                        <tr>
                            <th>Date start</th>
                            <th>Date End</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th> No of Travellers </th>
                            <!-- <th>Contact</th> -->
                            <th>Driver Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($user_upcoming_rides) {

                            foreach ($user_upcoming_rides as $user_upcoming_ride) { ?>
                                <tr>
                                    <td><?php echo date("Y-m-d", strtotime($user_upcoming_ride->date_from)); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($user_upcoming_ride->date_to)); ?></td>
                                    <td><?php echo $user_upcoming_ride->source; ?></td>
                                    <td><?php echo $user_upcoming_ride->destination; ?> </td>
                                    <td> <?php echo $user_upcoming_ride->no_of_travellers; ?> </td>

                                    <td>
                                        <?php
                                        $user_id = $user_upcoming_ride->assigned_user;
                                        $user_details = get_userdata($user_id);
                                        // $user_image = get_avatar_url($user_id);
                                        $phone_number = get_user_meta($user_id, 'phone_number', true);

                                        $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
                                        $profile_image_src = wp_get_attachment_url($profile_image_id);
                                        ?>

                                        <img src="<?php echo $profile_image_src ? $profile_image_src : $avatar_image; ?>" alt="driver" />
                                        <div class="driver_details">
                                            <span><?php echo $user_details->display_name; ?> </span>
                                            <span><?php echo $phone_number ?></span>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } else {
                            echo '<tr>';
                            echo '<td> No data found. </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php $user_completed_rides = $wpdb->get_results("SELECT * FROM $table WHERE `status` = 'booking' AND `user_id` = $current_user_id AND DATE(date_to)<NOW() ORDER BY id desc"); ?>
            <div class="table-wrapper paradise-customer-table">
                <h4 class="customer-completed-rides">Completed Journey</h4>
                <table class="paradise-table" id="pd-cust-table">
                    <thead>
                        <tr>
                            <th>Date start</th>
                            <th>Date End</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th> No of Travellers </th>
                            <!-- <th>Contact</th> -->
                            <th>Driver Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($user_completed_rides) {
                            foreach ($user_completed_rides as $user_completed_ride) { ?>
                                <tr>
                                    <td><?php echo date("Y-m-d", strtotime($user_completed_ride->date_from)); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($user_completed_ride->date_to)); ?></td>
                                    <td><?php echo $user_completed_ride->source; ?></td>
                                    <td><?php echo $user_completed_ride->destination; ?> </td>
                                    <td> <?php echo $user_completed_ride->no_of_travellers; ?> </td>

                                    <td>
                                        <?php
                                        $user_id = $user_completed_ride->assigned_user;
                                        $user_details = get_userdata($user_id);
                                        // $user_image = get_avatar_url($user_id);
                                        $phone_number = get_user_meta($user_id, 'phone_number', true);

                                        $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
                                        $profile_image_src = wp_get_attachment_url($profile_image_id);
                                        ?>

                                        <img src="<?php echo $profile_image_src ? $profile_image_src : $avatar_image; ?>" alt="driver" />
                                        <div class="driver_details">
                                            <span><?php echo $user_details->display_name; ?> </span><span>
                                                <?php echo $phone_number ?></span>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } else {
                            echo '<tr>';
                            echo '<td>No data found. </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    }
}


function book_car_callback_function()
{
    echo '<h2>' . __('Book your car', 'car-booking') . '</h2>'; ?>

    <div class="paradise-msg"></div>
    <div class="booking-success">Booked Successfully !</div>
    <form id="user_date_destination">
        <div class="booking_details">
            <div class="form-group">
                <span class="dashicons dashicons-calendar"></span>
                <label for="daterange">Date</label>
                <input type="text" name="daterange" class="booking_date_range" value="" />
            </div>
            <div class="form-group">
                <span class="dashicons dashicons-location"></span>
                <label for="location-from">Source</label>
                <input type="text" name="location-from" class="booking_source" placeholder="From">
            </div>
            <div class="form-group">
                <span class="dashicons dashicons-location"></span>
                <label for="location-to">Destination</label>
                <input type="text" name="location-to" class="booking_destination" placeholder="To">
            </div>
            <div class="form-group">
                <span class="dashicons dashicons-businessman"></span>
                <label for="number_of_travellers">Number of Travellers</label>
                <input type="number" name="number_of_travellers" class="booking_no_of_travellers" placeholder="Number of people">
            </div>
        </div>

        <div class="form-group drivers-details">
            <input type="hidden" class="driver_id">
            <img src="#" class="driver_vehicle_image " alt="vehicle">
            <img src="#" class="driver_profile_image" alt='driver'>
            <div class="paradise_driver_details">
                <span class="driver_name"> </span>
                <span class="driver_contact"></span>
            </div>

        </div>
        <div class="form-group">
            <input type="button" class="booking_next_button" value="Next">
        </div>

        <div class="form-group" id="user-side-submit-btn">
            <input type="button" class="booking_button" value="Submit">
        </div>
    </form>

<?php
}
