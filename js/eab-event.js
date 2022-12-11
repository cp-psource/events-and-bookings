jQuery(function() {
    jQuery(".hide-if-no-js").show();
    jQuery("#psourceevents-rsvps-response").hide();
    jQuery("#psourceevents-hide-rsvps").hide();

    jQuery("#psourceevents-load-rsvps").click(
        function() {
            jQuery("#psourceevents-rsvps-response").show();
            jQuery("#psourceevents-hide-rsvps").show();
            jQuery(this).hide();
            if (jQuery("#psourceevents-rsvps-response").text() == "") {
                jQuery("#psourceevents-rsvps-response").text("Wird geladen...");
                jQuery("#psourceevents-rsvps-response").load(jQuery("#psourceevents-load-rsvps").attr("href"));
            }
            return false;
        }
    );

    jQuery("#psourceevents-hide-rsvps").click(
        function() {
            jQuery("#psourceevents-rsvps-response").hide();
            jQuery("#psourceevents-load-rsvps").show();
            jQuery(this).hide();
            if (jQuery("#psourceevents-rsvps-response").text() == "") {
                jQuery("#psourceevents-rsvps-response").text("Wird geladen...");
                jQuery("#psourceevents-rsvps-response").load(jQuery("#psourceevents-load-rsvps").attr("href"));
            }
            return false;
        }
    );

    jQuery(".eab-buy_tickets-target").hide();
    jQuery(".eab-buy_tickets-trigger")
        .show()
        //.on('click', function () {
        .click(function() {
            jQuery(this).hide().parent().find(".eab-buy_tickets-target").show();
            return false;
        });
});