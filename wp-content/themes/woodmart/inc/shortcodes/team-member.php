<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_team_member_show_member_social' ) ) {
	/**
	 * Render member-social.
	 *
	 * @param array $settings Settings list.
	 *
	 * @return string|void
	 */
	function woodmart_shortcode_team_member_show_member_social( $settings ) {
		if ( empty( $settings['linkedin'] ) && empty( $settings['twitter'] ) && empty( $settings['facebook'] ) && empty( $settings['instagram'] ) ) {
			return '';
		}

		$classes  = 'wd-social-icons';
		$classes .= ' wd-style-' . $settings['style'];
		$classes .= ' wd-size-' . $settings['size'];
		$classes .= ' wd-shape-' . $settings['form'];
		$classes .= woodmart_get_old_classes( ' woodmart-social-icons' );

		if ( 'default' !== $settings['style'] ) {
			woodmart_enqueue_inline_style( 'social-icons-styles' );
		}

		?>
		<div class="member-social">
			<div class="<?php echo esc_attr( $classes ); ?>">
				<?php if ( ! empty( $settings['facebook'] ) ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-facebook" href="<?php echo esc_url( $settings['facebook'] ); ?>" aria-label="<?php echo esc_attr( __( 'Social icon facebook', 'woodmart' ) ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $settings['twitter'] ) ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-twitter" href="<?php echo esc_url( $settings['twitter'] ); ?>" aria-label="<?php echo esc_attr( __( 'Social icon X', 'woodmart' ) ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $settings['linkedin'] ) ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-linkedin" href="<?php echo esc_url( $settings['linkedin'] ); ?>" aria-label="<?php echo esc_attr( __( 'Social icon linkedin', 'woodmart' ) ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $settings['instagram'] ) ) : ?>
					<a rel="noopener noreferrer nofollow" class="wd-social-icon social-instagram" href="<?php echo esc_url( $settings['instagram'] ); ?>" aria-label="<?php echo esc_attr( __( 'Social icon instagram', 'woodmart' ) ); ?>">
						<span class="wd-icon"></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Team member shortcode
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_shortcode_team_member' ) ) {
	/**
	 * Team member element shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content content.
	 *
	 * @return string
	 */
	function woodmart_shortcode_team_member( $atts, $content = '' ) {
		$settings = shortcode_atts(
			array(
				'woodmart_css_id'       => '',
				'align'                 => 'left',
				'name'                  => '',
				'position'              => '',
				'twitter'               => '',
				'facebook'              => '',
				'linkedin'              => '',
				'instagram'             => '',
				'image'                 => '',
				'img_size'              => '270x170',
				'style'                 => 'default', // Circle colored.
				'size'                  => 'default', // Circle colored.
				'custom_icon_size'      => '',
				'form'                  => 'circle',
				'woodmart_color_scheme' => '',
				'layout'                => 'default',
				'css_animation'         => 'none',
				'el_class'              => '',
				'css'                   => '',
			),
			$atts
		);

		extract( $settings ); // phpcs:ignore.

		$classes  = 'wd-rs-' . $woodmart_css_id;
		$classes .= ' member-layout-' . $layout;
		$classes .= woodmart_get_css_animation( $css_animation );
		$classes .= ( $el_class ) ? ' ' . $el_class : '';
		$classes .= ! empty( $align ) ? ' text-' . $align : '';

		if ( $woodmart_color_scheme ) {
			$classes .= ' color-scheme-' . $woodmart_color_scheme;
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$img_id = preg_replace( '/[^\d]/', '', $image );
		$img    = woodmart_otf_get_image_html( $img_id, $img_size, array(), array( 'class' => 'team-member-avatar-image' ) );

		woodmart_enqueue_inline_style( 'social-icons' );
		woodmart_enqueue_inline_style( 'team-member' );

		ob_start();

		?>
		<div class="team-member wd-wpb <?php echo esc_attr( $classes ); ?>">
			<?php if ( ! empty( $img ) ) : ?>
				<div class="member-image-wrapper">
					<div class="member-image">
						<?php echo $img; // phpcs:ignore. ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="member-details wd-set-mb reset-last-child">
				<?php if ( ! empty( $name ) ) : ?>
					<h4 class="member-name">
						<?php echo esc_html( $name ); ?>
					</h4>
				<?php endif; ?>

				<?php if ( ! empty( $position ) ) : ?>
					<div class="member-position">
						<?php echo esc_html( $position ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="member-bio">
						<?php echo do_shortcode( $content ); ?>
					</div>
				<?php endif; ?>

				<?php woodmart_shortcode_team_member_show_member_social( $settings ); ?>
			</div>
		</div>

		<?php
		return ob_get_clean();
	}
}
