<?php
/*
Template Name: Drivers Archive
*/

echo do_shortcode('[elementor-template id="5423"]');
wp_head();

// Get all users with the 'driver' role
$args = array(
    'role'    => 'driver',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$drivers = get_users($args);
?>

<section>
    <div class="container driver-cards-container">
        <div class="cards-row flex driver-details-rows">
            <?php
            // Loop through each user
            foreach ($drivers as $user) {
                $user_id = $user->ID;
                $user_info = get_userdata($user_id);
                // $user_avatar = get_avatar_url($user_id);
                $profile_image_id = get_user_meta($user_id, 'profile_image_id', true);
                $profile_image_src = wp_get_attachment_url($profile_image_id);
                $display_name = $user_info->display_name;
                $user_name = $user_info->user_nicename;
                $user_link = home_url('/driver/' . $user_name);
                //$user_link = get_author_posts_url($user_id); 
                $avatar_image = plugin_dir_url(__FILE__) . '../public/assets/images/Profile_avatar_placeholder.png';
                ?>
                <div class="single-card driver-details">
                    <a href="<?php echo $user_link; ?>">
                        <img src="<?php echo $profile_image_src ? $profile_image_src: $avatar_image; ?>" alt="driver-img" title="driver-img" />
                        <div class="single-card-driver-contents">
                            <h4 class="flex align-center gap-10"><?php echo $display_name; ?></h4>
                            <p>Vehicle Type</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php
get_footer();