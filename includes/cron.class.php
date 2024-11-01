<?php 
/**
 * @Author	WebDevelope
 * @link http://webdevelope.net
 * @Package WordPress
 * @SubPackage WebDevelope Library
 * @copyright  Copyright (C) 2017+ WebDevelope
 * 
 * @version 0.1
 */
defined('ABSPATH') or die('You\'re not supposed to be here.');

/**
 * 
 * 
 * @author WebDevelope
 */
if (!class_exists('WebDevelopeNotify')):
class WebDevelopeNotify {
	var $FILE;
	
	/**
	 * Constructor.
	 *
	 */
	function __construct( $file ) {
		$this->FILE = $file;

		$option = get_option( "webdevelope_notify" );
		if ( $option && $option['__FILE__'] != $file ) {
			return false;
		}

		// Add cron if its not there
		WebDevelopeNotify::schedule_cron( $file );

		add_action( 'webdevelope_notify_daily_cron', array(
			 $this,
			'run_cron'
		) );

		add_action( 'wp_ajax_webdevelope_notify', array(
			 $this,
			'ajax_action' 
		) );

		if ( is_admin() ) {
			add_action( 'admin_notices', array(
				 $this,
				'admin_notice' 
			) );
		}

		return $this;
	}

	public static function schedule_cron( $file ) {
		if ( ! wp_next_scheduled( 'webdevelope_notify_daily_cron' ) ) {
			// Set the next event of fetching data
			wp_schedule_event( time(), 'daily', 'webdevelope_notify_daily_cron' );
		}

		if ( !get_option( "webdevelope_notify" ) ) {
			add_option( "webdevelope_notify", array(
				"__FILE__" => $file,
				"notify" => array()
			), '', 'yes' );
		}
	}

	public static function clear_schedule_cron( $file ) {
		$option = get_option( "webdevelope_notify" );
		if ( $option && $option['__FILE__'] == $file ) {
			delete_site_option( "webdevelope_notify" );
			delete_option( "webdevelope_notify" );

			wp_clear_scheduled_hook( "webdevelope_notify_daily_cron" );
		}
	}

	public function run_cron() {
		$args = array(
			'sslverify' => false
		);

		try {
			$plugin_data = get_plugin_data( $this->FILE, false, false );
			$plugin_data['locale'] = get_locale();
			$response = wp_remote_get( esc_url_raw( "http://api.webdevelope.net/wp-notify/?" . http_build_query( $plugin_data ) ) , $args );

			if ( !is_wp_error( $response ) && is_array( $response ) ) {
				$notify  = json_decode( wp_remote_retrieve_body( $response ), true );
			} else {
				$notify = array();
			}
		}
		catch (Exception $e) {
			$plugin_data = get_plugin_data( $this->FILE, false, false );
			echo $plugin_data['Name'] . ': ' . $e->getMessage();
			$notify = array();
		}

		if ( !empty( $notify ) ) {
			$notify_options = get_option( "webdevelope_notify" );
			$notify_option = $notify_options['notify'];

			if ( empty( $notify_option ) || $notify['id'] !== $notify_option['id'] ) {
				$notify_options['notify'] = $notify;
				update_option( "webdevelope_notify", $notify_options );
			}
		}

		return true;
	}

	public function admin_notice() {
		$notify = get_option( "webdevelope_notify" );
		$notify = $notify['notify'];
		if ( !empty( $notify ) && !$notify['dismissed'] ) {
?>
			<div class="<?php echo $notify['type']; ?>" id="<?php echo $notify['id']; ?>">
				<?php echo $notify['content']; ?>
			</div>
			<script type="text/javascript" charset="utf-8" async defer>
				jQuery(document).on( 'click', '#<?php echo $notify['id']; ?> .notice-dismiss', function() {
					var inputs = jQuery(this).parent().find('input'),
						nonce  = "<?php echo wp_create_nonce( 'webdevelope_notify_dismiss' ); ?>";

					jQuery.ajax({
						method: "POST",
						url: ajaxurl,
						data: {
							action: 'webdevelope_notify',
							task: 'dismiss_notify',
							nonce: nonce
						}
					});
				});
			</script>
			<?php
		}
	}
	/**
	 * Register ajax actions.
	 *
	 * @return  {void}
	 */
	public function ajax_action() {
		$result = array();
		$p      = @$_POST;

		$task = @$p['task'];
		$nonce = @$p['nonce'];

		unset( $p['wpesmtp_task'] );

		// check for rights
		if ( !$task || !wp_verify_nonce( $nonce, 'webdevelope_notify_dismiss' ) ) {
			$result = array(
				'status' => 403,
				'message' => __( "Bad Request" ) 
			);
		} else {
			if ( $task == "dismiss_notify" ) {
				$notify = get_option( "webdevelope_notify" );

				$notify['notify']['dismissed'] = true;
				update_option( "webdevelope_notify", $notify );

				$result = array(
					'status' => 200
				);
			}

			else
				$result = array(
					'status' => 400,
					'message' => __( "Bad Request" ) 
				);
		}
		
		wp_die( json_encode( $result ) );
	}

}
endif;