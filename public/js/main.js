jQuery(document).ready(function () {
  jQuery(".drivers-details, .booking_button").hide();
  

  // for booking
  jQuery(".booking_button").click(function () {
    var dateRange = jQuery(".booking_date_range").val();
    var source_val = jQuery(".booking_source").val();
    var destination_val = jQuery(".booking_destination").val();
    var noOfTravellers = jQuery(".booking_no_of_travellers").val();
    var driverId = jQuery(".driver_id").val();

    var date_range_split = dateRange.split("-");
    var startDate = date_range_split[0];
    var endDate = date_range_split[1];

    if (
      dateRange == "" ||
      source_val == "" ||
      destination_val == "" ||
      noOfTravellers == ""
    ) {
      alert("Fields cannot be empty.");
      return;
    }

    jQuery.ajax({
      type: "post",
      url: myajax.ajaxurl,
      data: {
        action: "book_date_range_for_car_booking",
        driver_id: driverId,
        source: source_val,
        destination: destination_val,
        no_of_travellers: noOfTravellers,
        start_date: moment(startDate).format("Y-MM-DD HH:mm:ss"),
        end_date: moment(endDate).format("Y-MM-DD HH:mm:ss"),
      },
      success: function (response) {
        console.log("response", response);
        if (response != "") {
          jQuery(".paradise-msg").text(response);
          return;
        }

        location.reload();
      },
    });
  });
  
  // for getting driver details
  jQuery(".booking_next_button").click(function () {
    var dateRange = jQuery(".booking_date_range").val();
    var source_val = jQuery(".booking_source").val();
    var destination_val = jQuery(".booking_destination").val();
    var noOfTravellers = jQuery(".booking_no_of_travellers").val();

    var date_range_split = dateRange.split("-");
    var startDate = date_range_split[0];
    var endDate = date_range_split[1];

    if (
      dateRange == "" ||
      source_val == "" ||
      destination_val == "" ||
      noOfTravellers == ""
    ) {
      alert("Fields cannot be empty.");
      return;
    }

    jQuery.ajax({
      type: "post",
      url: myajax.ajaxurl,
      data: {
        action: "paradise_random_driver",
        // source: source_val,
        // destination: destination_val,
        // no_of_travellers: noOfTravellers,
        start_date: moment(startDate).format("Y-MM-DD HH:mm:ss"),
        end_date: moment(endDate).format("Y-MM-DD HH:mm:ss"),
      },
      success: function (response) {
        // console.log("response", response);
        if (response.success == false) {
          jQuery(".paradise-msg").text(response.data);
          return;
        }
        if (response.success == true) {
          // console.log(response.data);
          jQuery(".driver_vehicle_image").attr(
            "src",
            response.data.vehicle_image
          );
          jQuery(".driver_profile_image").attr(
            "src",
            response.data.driver_image
          );
          jQuery(".driver_name").text(response.data.name);
          jQuery(".driver_contact").text(response.data.phone);
          jQuery(".driver_id").val(response.data.ID);

          jQuery(".drivers-details, .booking_button").show();
          jQuery(".booking_next_button").parent("div").hide();
          jQuery(".booking_details").hide();
          jQuery(".paradise-msg").text("");
        }
      },
    });
  });
});

jQuery(document).ready(function () {
  jQuery("#eyeIcon , #eyeIconConfirm").click(function () {
    var passwordField =
      jQuery(this).attr("id") === "eyeIcon" ? "#psw" : "#psw-confirm";
    if (jQuery(this).hasClass("fa-regular fa-eye")) {
      jQuery(this).removeClass("fa-regular fa-eye");
      jQuery(this).addClass("fa-regular fa-eye-slash");
      jQuery(passwordField).attr("type", "password");
    } else {
      jQuery(this).removeClass("fa-eye-slash");

      jQuery(this).addClass("fa-eye");
      jQuery(passwordField).attr("type", "text");
    }
  });
});
// sonika driver registration form
jQuery(document).ready(function () {
  jQuery(document).on("change", ".file-input", function () {
    var fileName = jQuery(this).val().split("\\").pop();
    // var fileName = jQuery(this).val();
    jQuery(this).parent().find(".file-name").text(fileName);
    console.log(fileName);
  });
});



jQuery(document).ready(function(){
  var dates = jQuery("#block_date_range").attr("data-blocked-date");

  jQuery('input[name="daterange"]').daterangepicker({
    minDate: new Date(),
    autoApply: true,
  });

  var json_date = JSON.parse(dates);


 // Set to store unique blocked dates
 var uniqueBlockedDates = new Set();

 jQuery.each(json_date, function(index, item) {
     let dates = item.blocked_date.split(',');
     jQuery.each(dates, function(i, date) {
         uniqueBlockedDates.add(date.trim());
     });
 });

 var uniqueBlockedDatesArray = Array.from(uniqueBlockedDates);

  jQuery('input[name="daterange_block"]').daterangepicker({
    minDate: new Date(),
    autoApply: true, 
    isInvalidDate: function (date) {
      for (var i = 0; i < uniqueBlockedDatesArray.length; i++) {
        // console.log('format',uniqueBlockedDatesArray[i]);
        if (date.format('YYYY-MM-DD') === uniqueBlockedDatesArray[i]) {
          return true;
        }
      }
      return false;
    },
  });
});