<?php
/**
 *
 * This file is used for rendering and saving plugin welcome settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
	// Exit if accessed directly.
}
?>

<div class="wbcom-tab-content">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-welcome-head">
			<p class="wbcom-welcome-description"><?php esc_html_e( 'BuddyPress Activity Filter allows to set your default option for activities. You can change the default from everything to Post Updates. The site administrator can remove some specific activity types from their BuddyPress Activity. It will also allow setting your default option for activities.', 'bp-activity-filter' ); ?></p>
		</div><!-- .wbcom-welcome-head -->

		<div class="wbcom-welcome-content">

			<div class="wbcom-welcome-support-info">
				<h3><?php esc_html_e( 'Help &amp; Support Resources', 'bp-activity-filter' ); ?></h3>
				<p><?php esc_html_e( 'Here are all the resources you may need to get help from us. Documentation is usually the best place to start. Should you require help anytime, our customer care team is available to assist you at the support center.', 'bp-activity-filter' ); ?></p>

				<div class="wbcom-support-info-wrap">
					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'bp-activity-filter' ); ?></h3>
						<p><?php esc_html_e( 'We have prepared an extensive guide on BuddyPress Activity Filter to learn all aspects of the plugin. You will find most of your answers here.', 'bp-activity-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://docs.wbcomdesigns.com/doc_category/buddypress-activity-filter/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Read Documentation', 'bp-activity-filter' ); ?></a>
						</div>
					</div>

					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Support Center', 'bp-activity-filter' ); ?></h3>
						<p><?php esc_html_e( 'We strive to offer the best customer care via our support center. Once your theme is activated, you can ask us for help anytime.', 'bp-activity-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/support/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Get Support', 'bp-activity-filter' ); ?></a>
					</div>
					</div>
					<div class="wbcom-support-info-widgets">
						<div class="wbcom-support-inner">
						<h3><span class="dashicons dashicons-admin-comments"></span><?php esc_html_e( 'Got Feedback?', 'bp-activity-filter' ); ?></h3>
						<p><?php esc_html_e( 'We want to hear about your experience with the plugin. We would also love to hear any suggestions you may for future updates.', 'bp-activity-filter' ); ?></p>
						<a href="<?php echo esc_url( 'https://wbcomdesigns.com/contact/' ); ?>" class="button button-primary button-welcome-support" target="_blank"><?php esc_html_e( 'Send Feedback', 'bp-activity-filter' ); ?></a>
					</div>
					</div>
				</div>
			</div>
		</div>	

	</div><!-- .wbcom-welcome-content -->
</div><!-- .wbcom-welcome-main-wrapper -->
