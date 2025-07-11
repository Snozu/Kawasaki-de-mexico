<?php
/**
 * Typography settings for particular CSS selectors.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Admin\Modules\Options\Field;
use XTS\Admin\Modules\Options;
use XTS\Admin\Modules\Options\Google_Fonts;
use XTS\Admin\Modules\Options\Presets;

/**
 * Class for typography settings control.
 */
class Typography extends Field {

	/**
	 * Default field value.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $_default_value = array(
		'selector'        => array(),
		'selector_var'    => array(),
		'google'          => false,
		'custom'          => false,
		'custom-selector' => '',
		'font-family'     => '',
		'font-weight'     => '',
		'font-variant'    => '',
		'font-style'      => '',
		'font-size'       => '',
		'line-height'     => '',
		'color'           => '',
		'background'      => '',
		'font-subset'     => '',
		'tablet'          => array(
			'font-size'   => '',
			'line-height' => '',
		),
		'mobile'          => array(
			'font-size'   => '',
			'line-height' => '',
		),
		'hover'           => array(
			'color'      => '',
			'background' => '',
		),
		'text-transform'  => '',
	);

	/**
	 * Google fonts array.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $google_fonts = array();

	/**
	 * Construct the object.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args     Field args array.
	 * @param array  $options  Options from the database.
	 * @param string $type     Field type.
	 * @param string $object   Object.
	 */
	public function __construct( $args, $options, $type = 'options', $object = 'post' ) {
		parent::__construct( $args, $options, $type, $object );

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ), 300 );

		add_action( 'admin_print_styles-post.php', array( $this, 'frontend_enqueue' ), 300 );
		add_action( 'admin_print_styles-post-new.php', array( $this, 'frontend_enqueue' ), 300 );
		add_action( 'admin_print_styles-widgets.php', array( $this, 'frontend_enqueue' ), 300 );

		$this->args = wp_parse_args(
			$args,
			array(
				'font-size'        => true,
				'line-height'      => true,
				'text-transform'   => false,
				'color'            => true,
				'color-hover'      => false,
				'selector'         => '',
				'selector-hover'   => false,
				'background'       => false,
				'background-hover' => false,
			)
		);

		$this->google_fonts = Google_Fonts::$all_google_fonts;
	}

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value = $this->get_field_value();
		// get last index from the array.
		$key = 0;
		if ( is_array( $value ) ) {
			end( $value );
			$key = key( $value );
		}

		echo '<div id="' . esc_attr( $this->get_id() ) . '" class="xts-advanced-typography-field ' . ( ( $this->_is_multiple_field() ) ? 'xts-multiple-typography' : 'xts-single-typography' ) . '" data-id="' . esc_attr( $this->get_id() ) . '" data-key="' . esc_attr( $key ) . '">';

		echo '<div class="xts-typography-sections">';

		if ( is_array( $value ) && count( $value ) > 0 && $this->_is_multiple_field() ) {
			foreach ( $value as $index => $value ) {
				$this->render_section( $index );
			}
		} else {
			$this->render_section( 0 );
		}

		echo '</div>';

		if ( $this->_is_multiple_field() ) {
			$this->section_template( false );
			echo '<div class="xts-typography-btn-add xts-font-section-add xts-inline-btn xts-color-primary xts-i-add">' . esc_html__( 'Add rule', 'woodmart' ) . '</div>';
		}

		echo '</div>';
	}

	/**
	 * Check is it multiple typography field.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean.
	 */
	private function _is_multiple_field() {
		return isset( $this->args['selectors'] );
	}

	/**
	 * Renders one typography settings section based on index.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $index  Section index.
	 *
	 * @return void.
	 */
	public function render_section( $index ) {
		$default_value = $this->_default_value;
		$value         = $this->get_field_value();
		$section_value = array();

		if ( '{{index}}' === $index ) {
			return;
		}

		if ( isset( $value[ $index ] ) ) {
			$section_value = wp_parse_args( $value[ $index ], $default_value );
		} else {
			$section_value = $default_value;
		}

		// Is selected font a Google font.
		$google = '0';

		if ( isset( $this->google_fonts[ $section_value['font-family'] ] ) ) {
			$google = '1';
		}

		$this->section_template(
			$index,
			array(
				'google' => $google,
				'value'  => $section_value,
			)
		);

	}

	/**
	 * Displays the section template.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $i  Section index.
	 * @param array   $data  Section data.
	 *
	 * @return void.
	 */
	public function section_template( $i, $data = array() ) {
		$index = ( false === $i ) ? '{{index}}' : $i;

		extract( // phpcs:ignore
			wp_parse_args(
				$data,
				array(
					'google' => '0',
					'value'  => $this->_default_value,
				)
			)
		);

		$default = isset( Options::get_default( $this->args )[ $i ] ) ? Options::get_default( $this->args )[ $i ] : array();

		$idle             = isset( $value['color'] ) ? $value['color'] : '';
		$hover            = isset( $value['hover']['color'] ) ? $value['hover']['color'] : '';
		$font_size        = isset( $value['font-size'] ) ? $value['font-size'] : '';
		$font_weight      = isset( $value['font-weight'] ) ? $value['font-weight'] : '';
		$transform        = isset( $value['text-transform'] ) ? $value['text-transform'] : '';
		$font_family      = isset( $value['font-family'] ) ? $value['font-family'] : '';
		$font_subset      = isset( $value['font-subset'] ) ? $value['font-subset'] : '';
		$background       = isset( $value['background'] ) ? $value['background'] : '';
		$background_hover = isset( $value['hover']['background'] ) ? $value['hover']['background'] : '';

		if ( ! $font_weight && ! $font_family ) {
			if ( isset( $default['font-family'] ) ) {
				$font_family = $default['font-family'];
			}

			if ( isset( $default['font-weight'] ) ) {
				$font_weight = $default['font-weight'];
			}
		}

		if ( ! $font_size && isset( $default['font-size'] ) ) {
			$font_size = $default['font-size'];
		}

		if ( ! $transform && isset( $default['text-transform'] ) ) {
			$transform = $default['text-transform'];
		}

		if ( ! $font_subset && isset( $default['font-subset'] ) ) {
			$font_subset = $default['font-subset'];
		}

		if ( ! $idle && isset( $default['color'] ) ) {
			$idle = $default['color'];
		}

		if ( ! $hover && isset( $default['hover']['color'] ) ) {
			$hover = $default['hover']['color'];
		}

		if ( ! $background && isset( $default['background'] ) ) {
			$background = $default['background'];
		}

		if ( ! $background_hover && isset( $default['hover']['background'] ) ) {
			$background_hover = $default['hover']['background'];
		}

		if ( empty( $this->args['selectors'] ) && isset( $this->args['callback'] ) ) {
			$this->args['selectors'] = $this->args['callback']();
		}

		?>
		<div class="xts-font-section xts-group xts-typography-section <?php echo ( ( false === $i ) ? 'xts-typography-template hide' : '' ); ?>" data-id="<?php echo esc_attr( $this->get_id() ); ?>-<?php echo esc_attr( $index ); ?>">
			<div class="xts-typography-font-container xts-row xts-sp-20">

				<?php if ( $this->_is_multiple_field() ) : ?>
					<div class="xts-col-12">
						<input type="hidden" class="xts-typography-custom-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'custom' ) ); ?>" value="<?php echo esc_attr( $value['custom'] ); ?>"  />
						<select class="xts-typography-selector" name="<?php echo esc_attr( $this->get_input_name( $index, 'selector', '' ) ); ?>" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Assigned to elements', 'woodmart' ); ?>">
							<?php
							$group = false;
							foreach ( $this->args['selectors'] as $id => $selector ) {
								if ( ! is_array( $selector ) ) {
									continue;
								}

								if ( ! isset( $selector['selector'] ) && ! isset( $selector['selector_var'] ) ) {
									if ( $group ) {
										echo '</optgroup>';
									}
									echo '<optgroup label="' . esc_attr( $selector['title'] ) . '">';
									$group = true;
									continue;
								}

								$attributes  = in_array( $id, $value['selector'], true ) ? ' selected="selected" ' : '';
								$attributes .= ! empty( $selector['hint'] ) ? ' data-hint-src="' . $selector['hint'] : '';
								echo '<option value="' . esc_attr( $id ) . '" ' . $attributes . '">'; // phpcs:ignore
								echo esc_html( $selector['title'] );
								echo '</option>';

							}
							if ( $group ) {
								echo '</optgroup>';
							}
							?>
						</select>
						<input type="text" placeholder="For ex.: .my-custom-class" class="xts-typography-custom-selector<?php echo ( ( ! $value['custom'] ) ? ' hide' : '' ); ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'custom-selector' ) ); ?>" value="<?php echo esc_attr( $value['custom-selector'] ); ?>"  />
					</div>
				<?php endif; ?>

				<div class="xts-col-12 xts-col-lg-6">
					<input type="hidden" class="xts-typography-google-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'google' ) ); ?>" value="<?php echo esc_attr( $google ); ?>">

					<input type="hidden" class="xts-typography-family-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'font-family' ) ); ?>" value="<?php echo esc_attr( $font_family ); ?>"  />

					<select class="xts-typography-family select2-container" data-placeholder="<?php esc_attr_e( 'Font family', 'woodmart' ); ?>" data-value="<?php echo esc_attr( $font_family ); ?>">
						<?php if ( $font_family ) : ?>
							<option>
								<?php echo esc_html( $font_family ); ?>
							</option>
						<?php else : ?>
							<option disabled selected>
								<?php esc_attr_e( 'Font family', 'woodmart' ); ?>
							</option>
						<?php endif; ?>
					</select>
				</div>

				<div class="xts-typography-style-container xts-col-12 xts-col-lg-6" original-title="<?php esc_attr_e( 'Font style', 'woodmart' ); ?>">
					<?php $style = $font_weight . $value['font-style']; ?>

					<input type="hidden" class="xts-typography-weight-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'font-weight' ) ); ?>" value="<?php echo esc_attr( $font_weight ); ?>"  />

					<input type="hidden" class="xts-typography-style-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'font-style' ) ); ?>" value="<?php echo esc_attr( $value['font-style'] ); ?>"/>

					<select data-placeholder="<?php esc_attr_e( 'Style', 'woodmart' ); ?>" class="xts-typography-style" original-title="<?php esc_attr_e( 'Font style', 'woodmart' ); ?>" data-value="<?php echo esc_attr( $style ); ?>">
					</select>
				</div>

				<div class="select_wrapper xts-typography-subsets-container xts-col-12 xts-col-lg-6" original-title="<?php esc_attr_e( 'Font subsets', 'woodmart' ); ?>">

					<input type="hidden" class="xts-typography-subset-input" name="<?php echo esc_attr( $this->get_input_name( $index, 'font-subset' ) ); ?>" value="<?php echo esc_attr( $font_subset ); ?>"/>
					<select data-placeholder="<?php esc_attr_e( 'Subset', 'woodmart' ); ?>" class="xts-typography-subset" original-title="<?php esc_attr_e( 'Font subset', 'woodmart' ); ?>"  data-value="<?php echo esc_attr( $font_subset ); ?>">
					</select>
				</div>

				<?php if ( $this->args['text-transform'] ) : ?>
					<div class="xts-col-12 xts-col-lg-6">
						<div class="xts-typography-extra-container">
							<select class="xts-typography-transform" data-placeholder="<?php esc_attr_e( 'Text transform', 'woodmart' ); ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'text-transform' ) ); ?>">
								<option value=""></option>
								<option value="capitalize" <?php selected( $transform, 'capitalize' ); ?>>Capitalize</option>
								<option value="lowercase" <?php selected( $transform, 'lowercase' ); ?>>Lowercase</option>
								<option value="uppercase" <?php selected( $transform, 'uppercase' ); ?>>Uppercase</option>
								<option value="none" <?php selected( $transform, 'none' ); ?>>None</option>
								<option value="inherit" <?php selected( $transform, 'inherit' ); ?>>Inherit</option>
							</select>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $this->args['font-size'] || $this->args['line-height'] ) : ?>
				<div class="xts-typography-text-container xts-row xts-sp-20">
					<?php if ( $this->args['font-size'] ) : ?>
						<div class="xts-col-12 xts-col-lg-6">
							<div class="xts-typography-size-container xts-typography-responsive-controls">
								<div class="xts-typography-size-point xts-typography-control-desktop xts-input-append-wrap">
									<label class="xts-i-desktop"><?php esc_html_e( 'Font size', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" name="<?php echo esc_attr( $this->get_input_name( $index, 'font-size' ) ); ?>" value="<?php echo esc_attr( $font_size ); ?>"  /><span class="add-on">px</span>
									</div>
								</div>
								<div class="xts-typography-responsive-opener xts-i-button-right" title="Responsive controls"></div>
								<div class="xts-typography-size-point xts-typography-control-tablet xts-input-append-wrap <?php echo ( ! empty( $value['tablet']['font-size'] ) ? 'show' : 'hide' ); ?>">
									<label class="xts-i-tablet"><?php esc_html_e( 'Tablet', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" name="<?php echo esc_attr( $this->get_input_name( $index, 'tablet', 'font-size' ) ); ?>" value="<?php echo esc_attr( $value['tablet']['font-size'] ); ?>"  /><span class="add-on">px</span>
									</div>
								</div>
								<div class="xts-typography-size-point xts-typography-control-mobile xts-input-append-wrap <?php echo ( ! empty( $value['tablet']['font-size'] ) ? 'show' : 'hide' ); ?>">
									<label class="xts-i-phone"><?php esc_html_e( 'Mobile', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" name="<?php echo esc_attr( $this->get_input_name( $index, 'mobile', 'font-size' ) ); ?>" value="<?php echo esc_attr( $value['mobile']['font-size'] ); ?>"  /><span class="add-on">px</span>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( $this->args['line-height'] ) : ?>
						<div class="xts-col-12 xts-col-lg-6">
							<div class="xts-typography-height-container xts-typography-responsive-controls">
								<div class="xts-typography-height-point xts-typography-control-desktop xts-input-append-wrap">
									<label class="xts-i-desktop"><?php esc_html_e( 'Line height', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" step="0.01" name="<?php echo esc_attr( $this->get_input_name( $index, 'line-height' ) ); ?>" value="<?php echo esc_attr( $value['line-height'] ); ?>"/><span class="add-on">px</span>
									</div>
								</div>
								<div class="xts-typography-responsive-opener xts-i-button-right" title="Responsive controls"></div>
								<div class="xts-typography-height-point xts-typography-control-tablet xts-input-append-wrap <?php echo ( ! empty( $value['tablet']['line-height'] ) ) ? 'show' : 'hide'; ?>">
									<label class="xts-i-tablet"><?php esc_html_e( 'Tablet', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" step="0.01" name="<?php echo esc_attr( $this->get_input_name( $index, 'tablet', 'line-height' ) ); ?>" value="<?php echo esc_attr( $value['tablet']['line-height'] ); ?>"/><span class="add-on">px</span>
									</div>
								</div>
								<div class="xts-typography-height-point xts-typography-control-mobile xts-input-append-wrap <?php echo ( ! empty( $value['tablet']['line-height'] ) ) ? 'show' : 'hide'; ?>">
									<label class="xts-i-phone"><?php esc_html_e( 'Mobile', 'woodmart' ); ?></label>
									<div class="xts-input-append">
										<input type="number" step="0.01" name="<?php echo esc_attr( $this->get_input_name( $index, 'mobile', 'line-height' ) ); ?>" value="<?php echo esc_attr( $value['mobile']['line-height'] ); ?>"/><span class="add-on">px</span>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $this->args['color'] || $this->args['color-hover'] || $this->args['background'] || $this->args['background-hover'] ) : ?>
				<div class="xts-typography-text-container xts-row xts-sp-20">
					<?php if ( $this->args['color'] ) : ?>
						<div class="xts-typography-color-container xts-col-12 xts-col-lg-6">
							<div class="xts-typography-color-point">
								<label>
									<?php esc_html_e( 'Color', 'woodmart' ); ?>
								</label>
								<input type="text" placeholder="<?php __( 'Color', 'woodmart' ); ?>" data-alpha-enabled="<?php echo isset( $this->args['alpha'] ) ? esc_attr( $this->args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'color' ) ); ?>" value="<?php echo esc_attr( $idle ); ?>" class="xts-typography-color color-picker" />
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $this->args['color-hover'] ) : ?>
						<div class="xts-typography-color-container xts-col-12 xts-col-lg-6">
							<div class="xts-typography-color-point">
								<label>
									<?php esc_html_e( 'Color on hover', 'woodmart' ); ?>
								</label>
								<input type="text" placeholder="<?php __( 'Color', 'woodmart' ); ?>" data-alpha-enabled="<?php echo isset( $this->args['alpha'] ) ? esc_attr( $this->args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'hover', 'color' ) ); ?>" value="<?php echo esc_attr( $hover ); ?>" class="xts-typography-color-hover color-picker" />
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $this->args['background'] ) : ?>
						<div class="xts-typography-color-container xts-typography-control-background xts-col-12 xts-col-lg-6">
							<div class="xts-typography-color-point">
								<label>
									<?php esc_html_e( 'Background', 'woodmart' ); ?>
								</label>
								<input type="text" placeholder="<?php __( 'Background', 'woodmart' ); ?>" data-alpha-enabled="<?php echo isset( $this->args['alpha'] ) ? esc_attr( $this->args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'background' ) ); ?>" value="<?php echo esc_attr( $background ); ?>" class="xts-typography-background color-picker" />
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $this->args['background-hover'] ) : ?>
						<div class="xts-typography-color-container xts-typography-control-background-hover xts-col-12 xts-col-lg-6">
							<div class="xts-typography-color-point">
								<label>
									<?php esc_html_e( 'Background on hover', 'woodmart' ); ?>
								</label>
								<input type="text" placeholder="<?php __( 'Background on hover', 'woodmart' ); ?>" data-alpha-enabled="<?php echo isset( $this->args['alpha'] ) ? esc_attr( $this->args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( $index, 'hover', 'background' ) ); ?>" value="<?php echo esc_attr( $background_hover ); ?>" class="xts-typography-background-hover color-picker" />
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<p class="xts-typography-preview hide">1 2 3 4 5 6 7 8 9 0 A B C D E F G H I J K L M N O P Q R S T U V W X Y Z a b c d e f g h i j k l m n o p q r s t u v w x y z</p>
			<?php if ( $this->_is_multiple_field() ) : ?>
				<div class="xts-typography-btn-remove xts-font-section-remove xts-inline-btn xts-color-warning xts-i-trash">
					<?php esc_html_e( 'Remove', 'woodmart' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Enqueue colorpicker lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', WOODMART_ASSETS . '/js/libs/wp-color-picker-alpha.js', array( 'wp-color-picker' ), woodmart_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'select2' );
		wp_enqueue_script(
			'webfontloader',
			'https://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js',
			array( 'jquery' ),
			'1.5.0',
			true
		);
	}

	/**
	 * Frontend enqueue .
	 *
	 * @since 1.0.0
	 */
	public function frontend_enqueue() {
		$this->add_google_fonts();
	}

	/**
	 * Add google fonts
	 *
	 * @since 1.0.0
	 */
	public function add_google_fonts() {
		if ( empty( $this->get_field_value() ) ) {
			return;
		}

		$active_presets = Presets::get_active_presets();

		if ( $active_presets ) {
			$this->set_presets( $active_presets );
		}

		$value = $this->get_field_value();

		foreach ( $value as $i => $typography ) {
			Google_Fonts::add_google_font( $typography );
		}
	}

	/**
	 * Output field's css code based on the settings.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Key.
	 * @param array  $typography Typography.
	 *
	 * @return string $output Generated CSS code.
	 */
	public function generate_var_css_code( $key, $typography ) {
		$output    = '';
		$suffix    = '';
		$std_fonts = woodmart_get_config( 'standard-fonts' );
		$value     = isset( $typography[ $key ] ) ? $typography[ $key ] : '';

		if ( 'color-hover' === $key ) {
			$value = isset( $typography['hover']['color'] ) ? $typography['hover']['color'] : '';
		} elseif ( 'background-hover' === $key ) {
			$value = isset( $typography['hover']['background'] ) ? $typography['hover']['background'] : '';
		}

		if ( ! $value ) {
			return $output;
		}

		if ( 'font-family' === $key ) {
			if ( in_array( $value, $std_fonts, true ) ) {
				$value = array_search( $value, $std_fonts, true );
			} else {
				$value  = '"' . $value . '"';
				$suffix = apply_filters( 'woodmart_backup_fonts', ', Arial, Helvetica, sans-serif' );
			}
		}

		if ( 'line-height' === $key || 'font-size' === $key ) {
			$suffix = 'px';
		}

		if ( isset( $this->args['selector_var'][ $key ] ) ) {
			$output .= $this->args['selector_var'][ $key ] . ': ' . $value . $suffix . ';' . "\n";
		} elseif ( isset( $typography['selector_var'][ $key ] ) ) {
			$output .= $typography['selector_var'][ $key ] . ': ' . $value . $suffix . ';' . "\n";
		}

		return $output;
	}

	/**
	 * Output field's css code based on the settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array $output Generated CSS code.
	 */
	public function css_output() {
		if ( empty( $this->get_field_value() ) ) {
			return array();
		}

		$value      = $this->get_field_value();
		$output_css = array();

		if ( empty( $this->args['selectors'] ) && ! empty( $this->args['callback'] ) ) {
			$this->args['selectors'] = $this->args['callback']();
		}

		foreach ( $value as $i => $typography ) {
			if ( isset( $this->args['callback'] ) && ! empty( $typography['selector'] ) ) {
				foreach ( $typography['selector'] as $key => $selector ) {
					if ( ! empty( $this->args['selectors'][ $selector ]['selector_var'] ) ) {
						$typography['selector_var'] = $this->args['selectors'][ $selector ]['selector_var'];

						if ( isset( $typography['tablet'] ) && is_array( $typography['tablet'] ) ) {
							$typography['tablet']['selector_var'] = $this->args['selectors'][ $selector ]['selector_var'];
						}
						if ( isset( $typography['mobile'] ) && is_array( $typography['mobile'] ) ) {
							$typography['mobile']['selector_var'] = $this->args['selectors'][ $selector ]['selector_var'];
						}

						unset( $value[ $i ]['selector'][ $key ] );
					}
				}

				if ( empty( $typography['selector_var'] ) ) {
					continue;
				}
			} elseif ( ! isset( $this->args['selector_var'] ) ) {
				continue;
			}

			$default     = Options::get_default( $this->args )[0];
			$idle        = isset( $typography['color'] ) ? $typography['color'] : '';
			$hover       = isset( $typography['hover'] ) ? $typography['hover']['color'] : '';
			$font_size   = isset( $typography['font-size'] ) ? $typography['font-size'] : '';
			$font_weight = isset( $typography['font-weight'] ) ? $typography['font-weight'] : '';
			$transform   = isset( $typography['text-transform'] ) ? $typography['text-transform'] : '';
			$font_family = isset( $typography['font-family'] ) ? $typography['font-family'] : '';
			$font_subset = isset( $typography['font-subset'] ) ? $typography['font-subset'] : '';

			if ( ! $font_subset && isset( $default['font-subset'] ) ) {
				$typography['font-subset'] = $default['font-subset'];
			}

			if ( ! $font_size && isset( $default['font-size'] ) ) {
				$typography['font-size'] = $default['font-size'];
			}

			if ( ! $font_weight && isset( $default['font-weight'] ) ) {
				$typography['font-weight'] = $default['font-weight'];
			}

			if ( ! $transform && isset( $default['text-transform'] ) ) {
				$typography['text-transform'] = $default['text-transform'];
			}

			if ( ! $font_family && isset( $default['font-family'] ) ) {
				$typography['font-family'] = $default['font-family'];
			}

			if ( ! $idle && isset( $default['color'] ) ) {
				$typography['color'] = $default['color'];
			}

			if ( ! $hover && isset( $default['hover']['color'] ) ) {
				$typography['hover']['color'] = $default['hover']['color'];
			}

			if ( ! empty( $typography['font-family'] ) || ! empty( $typography['font-weight'] ) || ! empty( $typography['text-transform'] ) || ! empty( $typography['color'] ) || ! empty( $typography['font-style'] ) || ! empty( $typography['font-size'] ) || ! empty( $typography['line-height'] ) || ! empty( $typography['background'] ) || ! empty( $typography['hover']['color'] ) || ! empty( $typography['hover']['background'] ) ) {
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'font-family', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'font-weight', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'text-transform', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'color', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'font-style', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'font-size', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'line-height', $typography );
				$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'background', $typography );

				if ( isset( $typography['hover'] ) ) {
					$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'color-hover', $typography );
					$output_css['desktop'][':root'][] = $this->generate_var_css_code( 'background-hover', $typography );
				}

				Google_Fonts::add_google_font( $typography );
			}

			if ( isset( $typography['tablet'] ) && is_array( $typography['tablet'] ) ) {
				if ( ! isset( $output_css['tablet'][':root'] ) ) {
					$output_css['tablet'][':root'] = array();
				}

				$output_css['tablet'][':root'][] = $this->generate_var_css_code( 'font-size', $typography['tablet'] );
				$output_css['tablet'][':root'][] = $this->generate_var_css_code( 'line-height', $typography['tablet'] );
			}

			if ( isset( $typography['mobile'] ) && is_array( $typography['mobile'] ) ) {
				if ( ! isset( $output_css['mobile'][':root'] ) ) {
					$output_css['mobile'][':root'] = array();
				}

				$output_css['mobile'][':root'][] = $this->generate_var_css_code( 'font-size', $typography['mobile'] );
				$output_css['mobile'][':root'][] = $this->generate_var_css_code( 'line-height', $typography['mobile'] );
			}
		}

		foreach ( $value as $typography ) {
			if ( empty( $typography['selector'] ) && $this->_is_multiple_field() || isset( $this->args['selector_var'] ) ) {
				continue;
			}

			if ( ! $this->_is_multiple_field() ) {
				$selector       = $this->args['selector'];
				$hover_selector = isset( $this->args['selector_hover'] ) ? $this->args['selector_hover'] : $this->args['selector'] . ':hover';
			} else {
				$custom_selector = isset( $typography['custom-selector'] ) ? $typography['custom-selector'] : false;
				$selector        = $this->_combine_selectors( $typography['selector'], false, $custom_selector );
				$hover_selector  = $this->_combine_selectors( $typography['selector'], 'hover', $custom_selector );
			}

			if ( isset( $this->args['selector-color-hover'] ) ) {
				$hover_selector = $this->args['selector-color-hover'];
			}

			$output_css['desktop'][ $selector ][] = $this->_generate_css_code( $typography );

			if ( isset( $typography['tablet'] ) && is_array( $typography['tablet'] ) ) {
				$output_css['tablet'][ $selector ][] = $this->_generate_css_code( $typography['tablet'] );
			}

			if ( isset( $typography['mobile'] ) && is_array( $typography['mobile'] ) ) {
				$output_css['mobile'][ $selector ][] = $this->_generate_css_code( $typography['mobile'] );
			}

			if ( $hover_selector !== $selector && isset( $typography['hover'] ) && is_array( $typography['hover'] ) ) {
				$output_css['desktop'][ $hover_selector ][] = $this->_generate_css_code( $typography['hover'] );
			}

			// Special selector for font family.
			if ( isset( $this->args['selector-font-family'] ) && isset( $typography['font-family'] ) ) {
				$output_css['desktop'][ $this->args['selector-font-family'] ][] = $this->_generate_css_code(
					array(
						'font-family' => $typography['font-family'],
						'font-weight' => $typography['font-weight'],
						'font-style'  => $typography['font-style'],
					)
				);
			}

			// Special selector for font size.
			if ( isset( $this->args['selector-font-size'] ) && isset( $typography['font-size'] ) ) {
				$output_css['desktop'][ $this->args['selector-font-size'] ][] = $this->_generate_css_code(
					array(
						'font-size'   => $typography['font-size'],
						'line-height' => $typography['line-height'],
					)
				);

				if ( isset( $typography['tablet'] ) && isset( $typography['tablet']['font-size'] ) ) {
					$output_css['tablet'][ $this->args['selector-font-size'] ][] = $this->_generate_css_code(
						array(
							'font-size'   => $typography['tablet']['font-size'],
							'line-height' => $typography['tablet']['line-height'],
						)
					);
				}

				if ( isset( $typography['mobile'] ) && isset( $typography['mobile']['font-size'] ) ) {
					$output_css['mobile'][ $this->args['selector-font-size'] ][] = $this->_generate_css_code(
						array(
							'font-size'   => $typography['mobile']['font-size'],
							'line-height' => $typography['mobile']['line-height'],
						)
					);
				}
			}

			// Special selector for color.
			if ( isset( $this->args['selector-color'] ) && isset( $typography['color'] ) ) {
				$output_css['desktop'][ $this->args['selector-color'] ][] = $this->_generate_css_code(
					array(
						'color' => $typography['color'],
					)
				);
			}

			Google_Fonts::add_google_font( $typography );
		}

		return $output_css;
	}

	/**
	 * Output CSS code inside the media query.
	 *
	 * @since 1.0.0
	 *
	 * @param string $query  CSS query.
	 * @param string $css  The code.
	 *
	 * @return  string $output Generated CSS code.
	 */
	private function _get_css_media_query( $query, $css, $root = false ) {
		if ( empty( $css ) ) {
			return '';
		}

		$code = $query . '{' . "\n";
		if ( $root ) {
			$code .= ':root{' . "\n";
		}
		$code .= $css;
		if ( $root ) {
			$code .= '}' . "\n";
		}
		$code .= '}' . "\n";
		return $code;
	}


	/**
	 * Generate CSS code based on rules array.
	 *
	 * @since 1.0.0
	 *
	 * @param string $selector  CSS selector.
	 * @param array  $rules  CSS rules array.
	 *
	 * @return  string $output Generated CSS code.
	 */
	private function _generate_css_code( $rules ) {
		$css_rules  = $this->_get_css_rule( 'font-family', $rules );
		$css_rules .= $this->_get_css_rule( 'font-weight', $rules );
		$css_rules .= $this->_get_css_rule( 'font-style', $rules );
		$css_rules .= $this->_get_css_rule( 'font-size', $rules );
		$css_rules .= $this->_get_css_rule( 'line-height', $rules );
		$css_rules .= $this->_get_css_rule( 'text-transform', $rules );
		$css_rules .= $this->_get_css_rule( 'color', $rules );
		$css_rules .= $this->_get_css_rule( 'background', $rules );

		return substr( $css_rules, 1 );
	}

	/**
	 * Generate a single CSS rule.
	 *
	 * @since 1.0.0
	 *
	 * @param string $rule  CSS rule.
	 * @param array  $rules_array  CSS rules array.
	 *
	 * @return  string $output Generated CSS code for this rule.
	 */
	private function _get_css_rule( $rule, $rules_array ) {
		if ( ! isset( $rules_array[ $rule ] ) || empty( $rules_array[ $rule ] ) ) {
			return '';
		}

		$std_fonts = woodmart_get_config( 'standard-fonts' );

		$suffix = '';
		if ( in_array( $rule, array( 'font-size', 'line-height' ), true ) ) {
			$suffix = 'px';
		}

		if ( in_array( $rule, array( 'font-family' ), true ) ) {
			if ( in_array( $rules_array[ $rule ], $std_fonts ) ) {
				return "\t" . $rule . ': ' . array_search( $rules_array[ $rule ], $std_fonts ) . ';';
			}

			$suffix = apply_filters( 'woodmart_backup_fonts', ', Arial, Helvetica, sans-serif' );

			return "\t" . $rule . ': "' . $rules_array[ $rule ] . '"' . $suffix . ";\n";
		}

		return "\t" . $rule . ': ' . $rules_array[ $rule ] . $suffix . ";\n";
	}

	/**
	 * Generate a complex selector based on selectors array, state and custom.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $selector_ids  CSS rule.
	 * @param string $state State like hover etc..
	 * @param string $custom Custom CSS selector.
	 *
	 * @return  string $string Generated CSS selector.
	 */
	private function _combine_selectors( $selector_ids, $state = false, $custom = false ) {
		if ( ! is_array( $selector_ids ) ) {
			return $selector_ids;
		}

		$selector = array();

		if ( empty( $this->args['selectors'] ) && isset( $this->args['callback'] ) ) {
			$this->args['selectors'] = $this->args['callback']();
		}

		foreach ( $selector_ids as $i => $id ) {
			if ( ! isset( $this->args['selectors'][ $id ] ) || ! isset( $this->args['selectors'][ $id ]['selector'] ) ) {
				continue;
			}

			$current_selector = $this->args['selectors'][ $id ]['selector'];

			// hover different selector.
			if ( 'hover' === $state && isset( $this->args['selectors'][ $id ]['selector-hover'] ) ) {
				$current_selector = $this->args['selectors'][ $id ]['selector-hover'];
			}

			if ( 'custom' === $id ) {
				$current_selector = $custom;

				if ( 'hover' === $state ) {
					$multiple = explode( ',', $current_selector );
					if ( count( $multiple ) > 1 ) {
						$current_selector = implode( ':hover,', $multiple );
					}

					$current_selector .= ':' . $state;
				}
			}

			$selector[ $i ] = $current_selector;
		}

		return implode( ', ', $selector );
	}
}
