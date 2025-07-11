<?php

if ( ! function_exists( 'woodmart_white_label' ) ) {
	function woodmart_white_label() {
		if ( ! woodmart_get_opt( 'white_label' ) ) {
			return;
		}

		$screenshot_data = woodmart_get_opt( 'white_label_appearance_screenshot' );
		?>

		<style>
			<?php if ( is_array( $screenshot_data ) && $screenshot_data['id'] ) : ?>
            .theme[aria-describedby="woodmart-action woodmart-name"] img, .theme[aria-describedby="woodmart-child-action woodmart-child-name"] img, .wd-woodmart-theme img, .wd-woodmart-theme .theme-info, .theme[data-slug="woodmart"] img, .theme[data-slug="woodmart-child"] img, .wd-woodmart-theme img{
				display: none;
			}

            .theme-browser .theme[aria-describedby="woodmart-action woodmart-name"]:focus .theme-screenshot, .theme-browser .theme[aria-describedby="woodmart-action woodmart-name"]:hover .theme-screenshot, .theme-browser .theme[aria-describedby="woodmart-child-action woodmart-child-name"]:focus .theme-screenshot, .theme-browser .theme[aria-describedby="woodmart-child-action woodmart-child-name"]:hover .theme-screenshot, .theme-browser .theme[data-slug="woodmart"]:focus .theme-screenshot, .theme-browser .theme[data-slug="woodmart"]:hover .theme-screenshot, .theme-browser .theme[data-slug="woodmart-child"]:focus .theme-screenshot, .theme-browser .theme[data-slug="woodmart-child"]:hover .theme-screenshot {
				opacity: 0.4;
			}

            .theme[aria-describedby="woodmart-action woodmart-name"] .theme-screenshot, .theme[aria-describedby="woodmart-child-action woodmart-child-name"] .theme-screenshot, .wd-woodmart-theme .screenshot, .theme[data-slug="woodmart"] .theme-screenshot, .theme[data-slug="woodmart-child"] .theme-screenshot {
				background-image: url(<?php echo esc_url( wp_get_attachment_image_url( $screenshot_data['id'], 'full' ) ); ?>) !important;
				background-repeat: no-repeat !important;
				background-position: center center !important;
				background-size: contain !important;
				background-color: transparent !important;
			}

			.theme-name#woodmart-name span , .theme-name#woodmart-child-name span{
				font-size: 15px;
			}
			<?php endif; ?>

			<?php if ( woodmart_get_opt( 'white_label_theme_name' ) ) : ?>
			.theme-name#woodmart-name:after {
				content: "<?php echo esc_html( woodmart_get_opt( 'white_label_theme_name' ) ); ?>";
				font-size: 15px;
				margin-left: 5px;
			}

			.theme-name#woodmart-name, .theme-name#woodmart-child-name {
				font-size:0
			}

			.theme-name#woodmart-child-name:after {
				content: "<?php echo esc_html( woodmart_get_opt( 'white_label_theme_name' ) ); ?>-child";
				font-size: 15px;
				margin-left: 5px;
			}
			<?php endif; ?>
		</style>
		<?php
	}

	add_filter( 'admin_print_styles', 'woodmart_white_label', -100 );
}

if ( ! function_exists( 'woodmart_white_label_add_body_class' ) ) {
	/**
	 * Add body classes.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	function woodmart_white_label_add_body_class( $classes ) {
		if ( ! woodmart_get_opt( 'white_label' ) || ! is_user_logged_in() ) {
			return $classes;
		}

		$white_label_logo = woodmart_get_opt( 'white_label_sidebar_icon_logo', array( 'url' => '' ) );

		if ( ! empty( $white_label_logo['url'] ) ) {
			$classes[] = 'wd-white-label-img';
		}

		return $classes;
	}

	add_filter( 'body_class', 'woodmart_white_label_add_body_class' );
}
