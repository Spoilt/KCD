<?php

define('CAFE_COFFEE_BLOCKS_NOTICE_BUY_NOW',__('https://www.wpradiant.net/products/cafe-wordpress-theme','cafe-coffee-blocks'));

define('CAFE_COFFEE_BLOCKS_BUY_BUNDLE',__('https://www.wpradiant.net/products/wordpress-theme-bundle','cafe-coffee-blocks'));

// Upsell
if ( class_exists( 'WP_Customize_Section' ) ) {
	class Cafe_Coffee_Blocks_Upsell_Section extends WP_Customize_Section {
		public $type = 'cafe-coffee-blocks-upsell';
		public $button_text = '';
		public $url = '';
		public $background_color = '';
		public $text_color = '';
		protected function render() {
			$background_color = ! empty( $this->background_color ) ? esc_attr( $this->background_color ) : '#3e84dc';
			$text_color       = ! empty( $this->text_color ) ? esc_attr( $this->text_color ) : '#fff';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="cafe_coffee_blocks_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title" style="color:#fff; background:<?php echo esc_attr( $background_color ); ?>;border-left-color:<?php echo esc_attr( $background_color ); ?>;">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}
function cafe_coffee_blocks_admin_notice_style() {
	wp_enqueue_style('cafe-coffee-blocks-custom-admin-notice-style', esc_url(get_template_directory_uri()) . '/get-started/getstart.css');
}
add_action('admin_enqueue_scripts', 'cafe_coffee_blocks_admin_notice_style');

/**
 * Display the admin notice if not dismissed.
 */
function cafe_coffee_blocks_admin_notice() {
    // Check if the notice is dismissed
    $dismissed = get_user_meta(get_current_user_id(), 'cafe_coffee_blocks_dismissed_notice', true);

    // Display the notice only if not dismissed
    if (!$dismissed) {
        ?>
        <div class="updated notice notice-success is-dismissible notice-get-started-class" data-notice="get-start" style="display: flex;padding: 10px;">
        		<div class="notice-content">
	        		<div class="notice-holder">
	                        <h5><span class="theme-name"><span><?php echo __('Welcome to Cafe Coffee Blocks', 'cafe-coffee-blocks'); ?></span></h5>
	                        <h1><?php echo __('Enhance Your Website Development with Radiant Blocks!!', 'cafe-coffee-blocks'); ?></h1>
	                        </h3>
	                        <div class="notice-text">
	                            <p class="blocks-text"><?php echo __('Effortlessly craft websites for any niche with Radiant Blocks! Experience seamless functionality and stunning responsiveness as you enhance your digital presence with Block WordPress Themes. Start building your ideal website today!', 'cafe-coffee-blocks') ?></p>
	                        </div>
	                        <a href="<?php echo esc_url(admin_url('themes.php?page=cafe-coffee-blocks')); ?>" id="install-activate-button" class="button admin-button info-button"><?php echo __('Getting started', 'cafe-coffee-blocks'); ?></a>

	                        <a href="<?php echo esc_url( CAFE_COFFEE_BLOCKS_NOTICE_BUY_NOW ); ?>" target="_blank" id="go-pro-button" class="button admin-button buy-now-button"><?php echo __('Buy Now ', 'cafe-coffee-blocks'); ?></a>

	                        <a href="<?php echo esc_url( CAFE_COFFEE_BLOCKS_BUY_BUNDLE ); ?>" target="_blank" id="bundle-button" class="button admin-button bundle-button"><?php echo __('Get Bundle', 'cafe-coffee-blocks'); ?></a>
	            	</div>
	            </div>
                <div class="theme-hero-screens">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/get-started/notice.png'); ?>" />
                </div>
        </div>
        <?php
    }
}

// Hook to display the notice
add_action('admin_notices', 'cafe_coffee_blocks_admin_notice');

/**
 * AJAX handler to dismiss the notice.
 */
function cafe_coffee_blocks_dismissed_notice() {
    // Set user meta to indicate the notice is dismissed
    update_user_meta(get_current_user_id(), 'cafe_coffee_blocks_dismissed_notice', true);
    die();
}

// Hook for the AJAX action
add_action('wp_ajax_cafe_coffee_blocks_dismissed_notice', 'cafe_coffee_blocks_dismissed_notice');

/**
 * Clear dismissed notice state when switching themes.
 */
function cafe_coffee_blocks_switch_theme() {
    // Clear the dismissed notice state when switching themes
    delete_user_meta(get_current_user_id(), 'cafe_coffee_blocks_dismissed_notice');
}

// Hook for switching themes
add_action('after_switch_theme', 'cafe_coffee_blocks_switch_theme');  