<?php
/*
Template Name: Single Driver
*/

echo do_shortcode('[elementor-template id="5423"]');
wp_head();

$author = get_queried_object();

if ($author && in_array('driver', $author->roles)) :
  $driver_id = $author->ID;
  $profile_image_id = get_user_meta($driver_id, 'profile_image_id', true);
  $profile_image_src = wp_get_attachment_url($profile_image_id);
  $vehicle_image = get_user_meta($driver_id, 'car_image_id', true);
  $number_of_seats_in_car = get_user_meta($driver_id, 'number_of_seats_in_car', true);
  $vehicle_image_src = wp_get_attachment_url($vehicle_image);?>
  <section class="single-driver-page">
    <div class="container driver-cards-container">
      <h2 class="text-center"><?php echo esc_html($author->display_name); ?></h2>
      <div class="single-driver-details-container">
        <img src="<?php echo esc_url($profile_image_src); ?>" alt="driver-image" />
        <div>

          <div class="single-driver-detail-inner-container">
            <h3>Bio</h3>
            <span>
              <h4 class="flex align-center gap-10">
                Name:</h4>
              <p><?php echo esc_html($author->display_name); ?></p>
            </span>
            <span>
              <h4 class="flex align-center gap-10">
                Vehicle Type:</h4>
              <p>.........................................................</p>
            </span>
            <span>
              <h4 class="flex align-center gap-10">
                Vehicle Specification: </h4>
              <p>..........................................................</p>
            </span>
            <span>
              <h4 class="flex align-center gap-10">
                Seat Capacity: </h4>
              <p><?php echo $number_of_seats_in_car ? $number_of_seats_in_car : 'N/A'; ?></p>
            </span>
          </div>
        </div>
      </div>
      <div class="single-driver-vehicle-img">
        <img src="<?php echo $vehicle_image_src; ?>" alt="vehicle-img" />
      </div>
    </div>
  </section>
<?php else : ?>
  <section>
    <div class="container single-driver-container">
      <div class="single-driver-profile">
        <h1>Driver Not Found</h1>
        <p>The driver you are looking for does not exist.</p>
        <a href="<?php echo esc_url(home_url('/drivers')); ?>">Back to Drivers</a>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
get_footer();
