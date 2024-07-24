<?php
/*
Template Name: Single Driver
*/

get_header();

$author = get_queried_object();

if ($author && in_array('driver', $author->roles)) :
    $driver_id = $author->ID;
    $profile_image_id = get_user_meta($driver_id, 'profile_image_id', true);
    $profile_image_src = wp_get_attachment_url($profile_image_id);
    ?>
    <section class="single-driver-page">
      <div class="container driver-cards-container">
        <div class="single-driver-details-container">
          <img src="<?php echo esc_url($profile_image_src); ?>" alt="driver-image" />
          <div>
            <h2 class="text-center"><?php echo esc_html($author->display_name); ?></h2>
            <div class="single-driver-detail-inner-container">
              <h4 class="text-center">Bio</h4>
              <h4 class="flex align-center gap-10">
                Name:
                <p><?php echo esc_html($author->display_name); ?></p>
              </h4>
              <h4 class="flex align-center gap-10">
                Vehicle Type:
                <p>Nice Vehicle</p>
              </h4>
              <h4 class="flex align-center gap-10">
                Name:
                <p>Nice vehicle</p>
              </h4>
              <h4 class="flex align-center gap-10">
                Name:
                <p>6</p>
              </h4>
            </div>
          </div>
        </div>
        <div class="single-driver-vehicle-img">
          <img src="vehicle.jpeg" alt="vehicle-img" />
        </div>
        <form>
          <button>Book Now <i class="fa-solid fa-arrow-right-long"></i></button>
        </form>
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

<style>
    .single-driver-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .single-driver-profile {
        text-align: center;
    }
    .single-driver-profile img {
        max-width: 200px;
        border-radius: 50%;
    }
    .single-driver-details {
        margin-top: 20px;
    }
</style>

<?php
get_footer();