<?php

class Eab_AdminTutorial {

	public static function serve () {
		if (!is_admin()) return false;
		$me = new self;
		$me->_add_hooks();
	}

	private function _add_hooks () {
		global $wp_version;
		if (version_compare($wp_version, "3.3") >= 0) {
		    add_action('admin_init', array($this, 'tutorial') );
		}
		add_action('wp_ajax_eab_restart_tutorial', array($this, 'handle_tutorial_restart'));
	}

	function tutorial() {
		//load the file
		require_once(EAB_PLUGIN_DIR . 'lib/pointers-tutorial/pointer-tutorials.php');

		//create our tutorial, with default redirect prefs
		$tutorial = new Pointer_Tutorial('eab_tutorial', true, false);

		//add our textdomain that matches the current plugin
		$tutorial->set_textdomain = Eab_EventsHub::TEXT_DOMAIN;

		//add the capability a user must have to view the tutorial
		$tutorial->set_capability = 'manage_options';
		$tutorial->hide_step = true;

		/*
		$tutorial->add_step(admin_url('edit.php?post_type=incsub_event&page=eab_settings'), 'incsub_event_page_eab_settings', '#incsub_event-slug', __('Event Slug', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . esc_js( __('Change the root slug for events', Eab_EventsHub::TEXT_DOMAIN) ) . '</p>',
		    'position' => array( 'edge' => 'left', 'align' => 'center' ),
		));

		$tutorial->add_step(admin_url('edit.php?post_type=incsub_event&page=eab_settings'), 'incsub_event_page_eab_settings', '#incsub_event-accept_payments', __('Accept Payments?', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . esc_js( __('Check this to accept payments for your events', Eab_EventsHub::TEXT_DOMAIN) ) . '</p>',
		    'position' => array( 'edge' => 'left', 'align' => 'center' ),
		));

		$tutorial->add_step(admin_url('edit.php?post_type=incsub_event&page=eab_settings'), 'incsub_event_page_eab_settings', '#incsub_event-display_attendees', __('Display RSVP\'s?', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . esc_js( __('Check this to display RSVP\'s in the event details', Eab_EventsHub::TEXT_DOMAIN) ) . '</p>',
		    'position' => array( 'edge' => 'left', 'align' => 'center' ),
		));

		$tutorial->add_step(admin_url('edit.php?post_type=incsub_event&page=eab_settings'), 'incsub_event_page_eab_settings', '#incsub_event-currency', __('Currency', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . esc_js(__('Which currency will you be accepting payment in? See ', Eab_EventsHub::TEXT_DOMAIN)) . '<a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes" target="_blank">Accepted PayPal Currency Codes</a></p>',
		    'position' => array( 'edge' => 'left', 'align' => 'center' ),
		));

		$tutorial->add_step(admin_url('edit.php?post_type=incsub_event&page=eab_settings'), 'incsub_event_page_eab_settings', '#incsub_event-paypal_email', __('PayPal E-Mail', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . esc_js(__('PayPal e-mail address payments should be made to', Eab_EventsHub::TEXT_DOMAIN)) . '</p>',
		    'position' => array( 'edge' => 'left', 'align' => 'center' ),
		));
		*/

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#title', __('Ereignistitel', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Was ist los", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'top', 'align' => 'center' ), 'post_type' => 'incsub_event',
		));

		if (defined('AGM_PLUGIN_URL')) {
		    $tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub_event_venue_label', __('Veranstaltungsort', Eab_EventsHub::TEXT_DOMAIN), array(
			'content'  => '<p>' . __("Wo? Gib die Adresse ein oder füge eine Karte ein, indem Du auf das Globussymbol klickst", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
			'position' => array( 'edge' => 'right', 'align' => 'left' ), 'post_type' => 'incsub_event',
		    ));
		} else {
		    $tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub_event_venue_label', __('Veranstaltungsort', Eab_EventsHub::TEXT_DOMAIN), array(
			'content'  => '<p>' . __("Wo? Gib die Adresse ein", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
			'position' => array( 'edge' => 'right', 'align' => 'left' ), 'post_type' => 'incsub_event',
		    ));
		}

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub_event_times_label', __('Veranstaltungszeit und -daten', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Wann? YYYY-mm-dd HH:mm", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'right', 'align' => 'left' ), 'post_type' => 'incsub_event',
		));

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub_event_status_label', __('Ereignisstatus', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Ist diese Veranstaltung noch offen für RSVP?", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'right', 'align' => 'left' ), 'post_type' => 'incsub_event',
		));

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub_event_paid_label', __('Ereignistyp', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Ist das eine bezahlte Veranstaltung? Wähle Ja und gibe in das angezeigte Textfeld ein, wie viel Du berechnen möchtest", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'right', 'align' => 'left' ), 'post_type' => 'incsub_event',
		));

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#wp-content-editor-container', __('Veranstaltungsdetails', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Mehr zur Veranstaltung", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'bottom', 'align' => 'center' ), 'post_type' => 'incsub_event',
		));

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#incsub-event-bookings', __("Veranstaltungs RSVPs", Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Sieh, wer anwesend ist, wer anwesend sein kann und wer nicht, nachdem Du die Veranstaltung veröffentlicht hast", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'bottom', 'align' => 'center' ), 'post_type' => 'incsub_event',
		));

		$tutorial->add_step(admin_url('post-new.php?post_type=incsub_event'), 'post-new.php', '#publish', __('Veröffentlichen', Eab_EventsHub::TEXT_DOMAIN), array(
		    'content'  => '<p>' . __("Jetzt ist es Zeit, die Veranstaltung zu veröffentlichen", Eab_EventsHub::TEXT_DOMAIN) . '</p>',
		    'position' => array( 'edge' => 'right', 'align' => 'center' ), 'post_type' => 'incsub_event',
		));

		//start the tutorial
		$tutorial->initialize();

		// $tutorial->restart(6);
		return $tutorial;
    }

	/**
	 * Handles tutorial restart requests.
	 */
	function handle_tutorial_restart () {
		$tutorial = $this->tutorial();
		$step = (int)$_POST['step'];
		$tutorial->restart($step);
		die;
	}
}
