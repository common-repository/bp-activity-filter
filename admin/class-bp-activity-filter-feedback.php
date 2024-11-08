<?php
/**
 * Plugin review class.
 * Prompts users to give a review of the plugin on WordPress.org after a period of usage.
 *
 * @package BuddyPress_Activity_Filter
 */

if ( ! class_exists( 'BP_Activity_Filter_Feedback' ) ) :

	/**
	 * The feedback class.
	 */
	class BP_Activity_Filter_Feedback {

		/**
		 * Slug.
		 *
		 * @var string $slug
		 */
		private $slug;

		/**
		 * Name.
		 *
		 * @var string $name
		 */
		private $name;

		/**
		 * Time limit.
		 *
		 * @var string $time_limit
		 */
		private $time_limit;

		/**
		 * No Bug Option.
		 *
		 * @var string $nobug_option
		 */
		public $nobug_option;

		/**
		 * Activation Date Option.
		 *
		 * @var string $date_option
		 */
		public $date_option;

		/**
		 * Class constructor.
		 *
		 * @param array $args Arguments.
		 */
		public function __construct( $args ) {
			$this->slug = sanitize_text_field( $args['slug'] );
			$this->name = sanitize_text_field( $args['name'] );

			$this->date_option  = $this->slug . '_activation_date';
			$this->nobug_option = $this->slug . '_no_bug';

			$this->time_limit = isset( $args['time_limit'] ) ? intval( $args['time_limit'] ) : WEEK_IN_SECONDS;

			// Add actions.
			add_action( 'admin_init', array( $this, 'check_installation_date' ) );
			add_action( 'admin_init', array( $this, 'set_no_bug' ), 5 );
		}

		/**
		 * Convert seconds to human-readable time.
		 *
		 * @param int $seconds Time in seconds.
		 * @return string Human-readable time.
		 */
		public function seconds_to_words( $seconds ) {

			// Get the years.
			$years = floor( $seconds / YEAR_IN_SECONDS );
			if ( $years > 1 ) {
				/* translators: Number of years */
				return sprintf( __( '%s years', 'bp-activity-filter' ), $years );
			} elseif ( $years > 0 ) {
				return __( 'a year', 'bp-activity-filter' );
			}

			// Get the weeks.
			$weeks = floor( $seconds / WEEK_IN_SECONDS ) % 52;
			if ( $weeks > 1 ) {
				/* translators: Number of weeks */
				return sprintf( __( '%s weeks', 'bp-activity-filter' ), $weeks );
			} elseif ( $weeks > 0 ) {
				return __( 'a week', 'bp-activity-filter' );
			}

			// Get the days.
			$days = floor( $seconds / DAY_IN_SECONDS ) % 7;
			if ( $days > 1 ) {
				/* translators: Number of days */
				return sprintf( __( '%s days', 'bp-activity-filter' ), $days );
			} elseif ( $days > 0 ) {
				return __( 'a day', 'bp-activity-filter' );
			}

			// Get the hours.
			$hours = floor( $seconds / HOUR_IN_SECONDS ) % 24;
			if ( $hours > 1 ) {
				/* translators: Number of hours */
				return sprintf( __( '%s hours', 'bp-activity-filter' ), $hours );
			} elseif ( $hours > 0 ) {
				return __( 'an hour', 'bp-activity-filter' );
			}

			// Get the minutes.
			$minutes = floor( $seconds / MINUTE_IN_SECONDS ) % 60;
			if ( $minutes > 1 ) {
				/* translators: Number of minutes */
				return sprintf( __( '%s minutes', 'bp-activity-filter' ), $minutes );
			} elseif ( $minutes > 0 ) {
				return __( 'a minute', 'bp-activity-filter' );
			}

			// Get the seconds.
			$seconds = intval( $seconds ) % 60;
			if ( $seconds > 1 ) {
				/* translators: Number of seconds */
				return sprintf( __( '%s seconds', 'bp-activity-filter' ), $seconds );
			} elseif ( $seconds > 0 ) {
				return __( 'a second', 'bp-activity-filter' );
			}

			return __( 'just now', 'bp-activity-filter' );
		}

		/**
		 * Check date on admin initiation and add to admin notice if it was more than the time limit.
		 */
		public function check_installation_date() {
			if ( ! get_site_option( $this->nobug_option ) || false === get_site_option( $this->nobug_option ) ) {
				add_site_option( $this->date_option, time() );

				// Retrieve the activation date.
				$install_date = get_site_option( $this->date_option );

				// If difference between install date and now is greater than time limit, then display notice.
				if ( ( time() - $install_date ) > $this->time_limit ) {
					add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
				}
			}
		}

		/**
		 * Display the admin notice.
		 */
		public function display_admin_notice() {
			$screen = get_current_screen();

			if ( isset( $screen->base ) && 'plugins' === $screen->base ) {
				$no_bug_url = wp_nonce_url( admin_url( '?' . $this->nobug_option . '=true' ), 'bp-activity-filter-feedback-nonce' );
				$time       = $this->seconds_to_words( time() - get_site_option( $this->date_option ) );
				?>

<style>
.notice.bp-activity-filter-notice {
	border-left-color: #008ec2 !important;
	padding: 20px;
}

.rtl .notice.bp-activity-filter-notice {
	border-right-color: #008ec2 !important;
}

.notice.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner {
	display: table;
	width: 100%;
}

.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-notice-icon,
.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-notice-content,
.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-install-now {
	display: table-cell;
	vertical-align: middle;
}

.notice.bp-activity-filter-notice .bp-activity-filter-notice-icon {
	color: #509ed2;
	font-size: 50px;
	width: 60px;
}

.notice.bp-activity-filter-notice .bp-activity-filter-notice-icon img {
	width: 64px;
}

.notice.bp-activity-filter-notice .bp-activity-filter-notice-content {
	padding: 0 40px 0 20px;
}

.notice.bp-activity-filter-notice p {
	padding: 0;
	margin: 0;
}

.notice.bp-activity-filter-notice h3 {
	margin: 0 0 5px;
}

.notice.bp-activity-filter-notice .bp-activity-filter-install-now {
	text-align: center;
}

.notice.bp-activity-filter-notice .bp-activity-filter-install-now .bp-activity-filter-install-button {
	padding: 6px 50px;
	height: auto;
	line-height: 20px;
}

.notice.bp-activity-filter-notice a.no-thanks {
	display: block;
	margin-top: 10px;
	color: #72777c;
	text-decoration: none;
}

.notice.bp-activity-filter-notice a.no-thanks:hover {
	color: #444;
}

@media (max-width: 767px) {

	.notice.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner {
		display: block;
	}

	.notice.bp-activity-filter-notice {
		padding: 20px !important;
	}

	.notice.bp-activity-filter-noticee .bp-activity-filter-notice-inner {
		display: block;
	}

	.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-notice-content {
		display: block;
		padding: 0;
	}

	.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-notice-icon {
		display: none;
	}

	.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .bp-activity-filter-install-now {
		margin-top: 20px;
		display: block;
		text-align: left;
	}

	.notice.bp-activity-filter-notice .bp-activity-filter-notice-inner .no-thanks {
		display: inline-block;
		margin-left: 15px;
	}
}
</style>
			<div class="notice updated bp-activity-filter-notice">
				<div class="bp-activity-filter-notice-inner">
					<div class="bp-activity-filter-notice-icon">
						<img src="<?php echo esc_url( BP_ACTIVITY_FILTER_PLUGIN_URL . '/admin/images/wbcom.png' ); ?>" alt="<?php echo esc_attr__( 'BuddyPress Activity Filter', 'bp-activity-filter' ); ?>" />
					</div>
					<div class="bp-activity-filter-notice-content">
						<h3><?php echo esc_html__( 'Are you enjoying BuddyPress Activity Filter?', 'bp-activity-filter' ); ?></h3>
						<p>
							<?php /* translators: 1. Name, 2. Time */ ?>
							<?php printf( esc_html__( 'We hope you\'re enjoying %1$s! Could you please do us a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?', 'bp-activity-filter' ), esc_html( $this->name ) ); ?>
						</p>
					</div>
					<div class="bp-activity-filter-install-now">
						<?php printf( '<a href="%1$s" class="button button-primary bp-activity-filter-install-button" target="_blank">%2$s</a>', esc_url( 'https://wordpress.org/support/view/plugin-reviews/bp-activity-filter#new-post' ), esc_html__( 'Leave a Review', 'bp-activity-filter' ) ); ?>
						<a href="<?php echo esc_url( $no_bug_url ); ?>" class="no-thanks"><?php echo esc_html__( 'No thanks / I already have', 'bp-activity-filter' ); ?></a>
					</div>
				</div>
			</div>
				<?php
			}
		}

		/**
		 * Set the plugin to no longer bug users if user asks not to be.
		 */
		public function set_no_bug() {

			// Bail out if not on the correct page.
			if ( ! isset( $_GET['_wpnonce'] ) || ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'bp-activity-filter-feedback-nonce' ) || ! is_admin() || ! isset( $_GET[ $this->nobug_option ] ) || ! current_user_can( 'manage_options' ) ) ) {
				return;
			}

			add_site_option( $this->nobug_option, true );
		}
	}
endif;

/*
* Instantiate the BP_Activity_Filter_Feedback class.
*/
new BP_Activity_Filter_Feedback(
	array(
		'slug'       => 'bp_activity_filter',
		'name'       => __( 'BuddyPress Activity Filter', 'bp-activity-filter' ),
		'time_limit' => WEEK_IN_SECONDS,
	)
);
