<?php

/**
 * Shortcode for registration of driver
 * Use shortcode [driver-registration]
 */
add_shortcode('driver-registration', 'driver_registration_callback');
function driver_registration_callback()
{
    ob_start();
    if (isset($_POST['submit'])) {
        $firstname = sanitize_text_field($_POST['firstName']);
        $lastname = sanitize_text_field($_POST['lastName']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['psw']);
        $confirmPw = sanitize_text_field($_POST['psw-confirm']);
        $phone = $_POST['phone_number'];
        $no_seats = $_POST['no_seats'];
        $baggage_limit = $_POST['baggage_limit'];
        $language_spoken = $_POST['language_spoken'];
        $video_url = sanitize_url($_POST['video_url'], array('http', 'https'));
        $languages = explode(",", $language_spoken);
        $username = strtolower(str_replace(' ', '', $firstname));
        if ($password == $confirmPw) {
            if (strlen($phone) == 10) {
                if (!username_exists($username)) {
                    $user_id = wp_create_user($username, $password, $email);
                    if (!is_wp_error($user_id)) {
                        update_user_meta($user_id, 'first_name', $firstname);
                        update_user_meta($user_id, 'last_name', $lastname);
                        update_user_meta($user_id, 'phone_number', $phone);
                        update_user_meta($user_id, 'number_of_seats_in_car', $no_seats);
                        update_user_meta($user_id, 'baggage_capacity_in_car', $baggage_limit);
                        update_user_meta($user_id, 'spoken_language', $languages);
                        update_user_meta($user_id, 'driver_video_url', $video_url);
                        $user = new WP_User($user_id);
                        $user->set_role('driver');
                        if (!empty($_FILES['ps-driver-img']['name'])) {
                            upload_image($_FILES['ps-driver-img'], 'profile_image_id', $user_id);
                        }
                        if (!empty($_FILES['ps-car-img']['name'])) {
                            upload_image($_FILES['ps-car-img'], 'car_image_id', $user_id);
                        }
                        if (!empty($_FILES['ps-driver-liscence']['name'])) {
                            upload_image($_FILES['ps-driver-liscence'], 'liscence', $user_id);
                        }
                        if (!empty($_FILES['ps-other-docs1']['name'])) {
                            upload_image($_FILES['ps-other-docs1'], 'other_doc1_id', $user_id);
                        }
                        if (!empty($_FILES['ps-other-docs2']['name'])) {
                            upload_image($_FILES['ps-other-docs2'], 'other_doc2_id', $user_id);
                        }
                        echo 'User registered successfully!';
                        wp_redirect(home_url('/my-account/'));
                    } else {
                        echo 'Error: ' . $user_id->get_error_message();
                    }
                } else {
                    echo "Username already exists";
                }
            } else {
                echo "Incorrect phone number";
            }
        } else {
            echo "Password doesnot match";
        }
    } 
    if(!is_user_logged_in()){?>
    <div class="driver-form-wrapper">
        <div class="driver-form-container">
            <form class="driver-registration-form" method="POST" enctype="multipart/form-data">
                <div class="full-name form-group-wrapper">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" placeholder="Enter first name" name="firstName" id="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" placeholder="Enter last name" name="lastName" id="lastName">
                    </div>
                </div>
                <div class="unique-details form-group-wrapper">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Enter Email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="number" placeholder="Enter your phone number" name="phone_number" id="phone_number" required>
                    </div>
                </div>
                <div class="passwords form-group-wrapper">
                    <div class="form-group">
                        <label for="psw">Password</label>
                        <i id="eyeIcon" class="fa-regular fa-eye-slash"></i>
                        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                    </div>
                    <div class="form-group">
                        <label for="psw-confirm">Confirm Password</label>
                        <i id="eyeIconConfirm" class="fa-regular fa-eye-slash"></i>
                        <input type="password" placeholder="Confirm Password" name="psw-confirm" id="psw-confirm" required>
                    </div>
                </div>
                <div class="seats-limit form-group-wrapper">
                    <div class="form-group">
                        <label for="no_seats">Number of Seats</label>
                        <input type="number" placeholder="Number of Seats" name="no_seats" id="no_seats_in_car" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="video_url">Video URL</label>
                        <input type="url" placeholder="Video URL" name="video_url" id="video_url" required>
                    </div>
                </div>
                <div class="form-group driver-file-upload">
                    <div class="file-upload-wrapper">
                        <input type="file" id="ps-driver-img" name="ps-driver-img" class="file-input" />
                        <label for="ps-driver-img" class="file-label">
                            <span class="file-button" id="drider_image">Upload driver image</span>
                            <span class="file-name">No file chosen</span>
                        </label>
                    </div>
                    <div class="file-upload-wrapper">
                        <input type="file" id="ps-car-img" name="ps-car-img" class="file-input" />
                        <label for="ps-car-img" class="file-label">
                            <span class="file-button" id="car_image">Upload car image</span>
                            <span class="file-name">No file chosen</span>
                        </label>
                    </div>
                    <div class="file-upload-wrapper">
                        <input type="file" id="ps-driver-liscence" name="ps-driver-liscence" class="file-input" />
                        <label for=" ps-driver-liscence" class="file-label">
                            <span class="file-button" id="driver_liscence">Upload driver liscense</span>
                            <span class="file-name">No file chosen</span>
                        </label>
                    </div>
                    <div class="file-upload-wrapper">
                        <input type="file" id="ps-other-docs1" name="ps-other-docs1" class="file-input" accept=".pdf,.doc,.docx,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                        <label for="ps-other-docs1" class="file-label">
                            <span class="file-button" id="other_document1">Upload documents</span>
                            <span class="file-name">No file chosen</span>
                        </label>
                    </div>
                    <div class="file-upload-wrapper">
                        <input type="file" id="ps-other-docs2" name="ps-other-docs2" class="file-input" accept=".pdf,.doc,.docx,image/*,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                        <label for="ps-other-docs2" class="file-label">
                            <span class="file-button" id="other_document2">Upload documents</span>
                            <span class="file-name">No file chosen</span>
                        </label>
                    </div>
                </div>
                <input type="submit" name="submit" class="driver-form-submit">
            </form>
        </div>
    </div>
<?php
    }else{
        echo 'Only for non logged user. Please Logout first.';
    }
    $output = ob_get_contents();
    ob_get_clean();
    return $output;
}

function upload_image($file, $meta_key, $user_id)
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
