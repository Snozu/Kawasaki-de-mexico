<?php
/**
 * Basic field abstract class.
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Abstract class for the field.
 */
abstract class Field {

	/**
	 * ID of the field
	 *
	 * @var int
	 */
	private $_id;

	/**
	 * Args array for the field
	 *
	 * @var array
	 */
	public $args = array();

	/**
	 * Options array from the database for the field value.
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Options set prefix.
	 *
	 * @var string
	 */
	public $opt_name = 'woodmart';

	/**
	 * Field type
	 *
	 * @var string
	 */
	public $_type;

	/**
	 * Post object. Required for metabox field to get the value from the database.
	 *
	 * @var null
	 */
	public $_post = null;

	/**
	 * Term object. Required for metabox field to get the value from the database.
	 *
	 * @var null
	 */
	public $_term = null;

	/**
	 * Metabox object. Post or term.
	 *
	 * @var null
	 */
	public $_object = null;

	/**
	 * Presets IDs.
	 *
	 * @var null
	 */
	public $_presets = false;

	/**
	 * Is this field inherits value. (not use preset value)
	 *
	 * @var boolean
	 */
	private $_inherit_value;

	/**
	 * Extra wrapper CSS class.
	 *
	 * @var string
	 */
	public $extra_css_class = '';

	/**
	 * Inner fields object.
	 *
	 * @var array
	 */
	public $inner_fields = array();

	/**
	 * Construct the object.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args Field args array.
	 * @param array  $options Options from the database.
	 * @param string $type Field type.
	 * @param string $object $object   Object for post or term.
	 */
	public function __construct( $args, $options, $type = 'options', $object = 'post' ) {
		$this->args = $args;
		$this->_id  = $args['id'];

		if ( $options ) {
			$this->options = $options;
		}

		$this->_type   = $type;
		$this->_object = $object;

		$this->extra_css_class  = 'xts-' . $this->args['type'] . '-control';
		$this->extra_css_class .= ' xts-' . $this->args['id'] . '-field';

		if ( $this->dependency_class() ) {
			$this->extra_css_class .= ' ' . $this->dependency_class();
		}

		if ( isset( $this->args['class'] ) ) {
			$this->extra_css_class .= ' ' . $this->args['class'];
		}

		if ( isset( $this->args['tabs'] ) ) {
			$this->extra_css_class .= ' xts-tabs xts-style-' . $this->args['tabs'];
		}
	}

	/**
	 * Validate field value. For example check file ID and URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string or array $value Field value.
	 *
	 * @return mixed
	 */
	public function validate( $value ) {
		return $value;
	}

	/**
	 * ID getter
	 *
	 * @since 1.0.0
	 *
	 * @return int field id value.
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Update options array. Needed for presets functionality on the demo website.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $options New options array.
	 */
	public function override_options( $options ) {
		$this->options = $options;
	}

	/**
	 * Set post
	 *
	 * @since 1.0.0
	 *
	 * @param  object $object Post object for metaboxes fields.
	 */
	public function set_post( $object ) {
		if ( 'metabox' === $this->_type ) {
			if ( is_a( $object, 'WP_Post' ) ) {
				$this->_post = $object;
			} elseif ( is_a( $object, 'WP_Term' ) ) {
				$this->_term = $object;
			}
		}
	}

	/**
	 * Render the field HTML based on the control class.
	 *
	 * @since 1.0.0
	 *
	 * @param object $object Post or Term object for metaboxes fields.
	 * @param bool   $preset Current field preset ID.
	 */
	public function render( $object = null, $preset = false, $is_inner_control = false ) {
		if ( $preset ) {
			$this->_presets = array( $preset );
		}

		if ( $preset && $this->is_inherit_value() && ! isset( $this->args['tabs'] ) && ! $is_inner_control ) {
			$this->extra_css_class .= ' xts-field-disabled';
		}

		if ( is_a( $object, 'WP_Post' ) ) {
			$this->_post = $object;
		} elseif ( is_a( $object, 'WP_Term' ) ) {
			$this->_term = $object;
		}

		$this->before( $is_inner_control );

		$this->enqueue();

		echo '<div class="xts-option-control">';
		$this->render_control();
		echo '</div>';

		$this->after();

	}

	/**
	 * Before the control output.
	 *
	 * @since 1.0.0
	 */
	public function before( $is_inner_control = false ) {
		?>
			<div class="xts-field xts-settings-field <?php echo esc_attr( $this->extra_css_class ); ?>" <?php $this->get_dependency_data_attribute(); ?>>
				<?php if ( ( isset( $this->args['description'] ) && ! empty( $this->args['description'] ) ) || ( isset( $this->args['name'] ) && ! empty( $this->args['name'] ) ) ) : ?>
					<div class="xts-option-title">
						<label>
							<?php if ( false !== $this->_presets && 'notice' !== $this->args['type'] && ! isset( $this->args['tabs'] ) && isset( $_GET['preset'] ) && ! $is_inner_control ) : // phpcs:ignore ?>
								<div class="xts-inherit-checkbox-wrapper">
									<?php esc_html_e( 'Inherit', 'woodmart' ); ?>
									<input type="checkbox" <?php checked( true, $this->is_inherit_value() ); ?> data-name="<?php echo esc_attr( $this->args['id'] ); ?>" value="1">
								</div>
							<?php endif; ?>

							<?php $this->get_field_label(); ?>
						</label>

						<?php if ( ! empty( $this->args['status'] ) ) : ?>
							<div class="xts-field-status xts-status-<?php echo esc_attr( $this->args['status'] ); ?><?php echo ! empty( $this->args['status_description'] ) ? ' xts-status-hint' : ''; ?>">
								<span class="xts-status-label">
									<?php if ( 'deprecated' === $this->args['status'] ) : ?>
										<?php esc_html_e( 'Deprecated', 'woodmart' ); ?>
									<?php endif; ?>
								</span>
								<?php if ( ! empty( $this->args['status_description'] ) ) : ?>
									<span class="xts-status-icon xts-i-help-question"></span>
									<div class="xts-tooltip xts-top"><div class="xts-tooltip-inner"><?php echo $this->args['status_description']; // phpcs:ignore ?></div></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $this->args['hint'] ) && woodmart_get_opt( 'white_label_theme_hints', true ) ) : ?>
							<div class="xts-hint">
								<div class="xts-tooltip xts-top"><div class="xts-tooltip-inner"><?php echo $this->args['hint']; // phpcs:ignore ?></div></div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
		<?php
	}

	/**
	 * Get field label.
	 *
	 * @return void
	 */
	public function get_field_label() {
		?>
			<span>
				<?php if ( isset( $this->args['name'] ) && ! empty( $this->args['name'] ) ) : ?>
					<?php echo $this->args['name']; // phpcs:ignore ?>
				<?php endif; ?>
			</span>
		<?php
	}

	/**
	 * Set field's presets IDs.
	 *
	 * @since 1.0.0
	 *
	 * @param  int $id Presets Ids.
	 */
	public function set_presets( $id ) {
		$this->_presets = $id;
	}

	/**
	 * Set inherit value flag.
	 *
	 * @since 1.0.0
	 *
	 * @param  boolean $value Yes or no.
	 */
	public function inherit_value( $value ) {
		$this->_inherit_value = $value;
	}

	/**
	 * Inherit value flag getter.
	 *
	 * @since 1.0.0
	 */
	public function is_inherit_value() {
		return $this->_inherit_value;
	}

	/**
	 * Echo dependency data attribute.
	 *
	 * @since 1.0.0
	 */
	private function get_dependency_data_attribute() {
		if ( ! isset( $this->args['requires'] ) ) {
			return;
		}

		$data = '';

		foreach ( $this->args['requires'] as $dependency ) {
			if ( is_array( $dependency['value'] ) ) {
				$dependency['value'] = implode( ',', $dependency['value'] );
			}
			$data .= $dependency['key'] . ':' . $dependency['compare'] . ':' . $dependency['value'] . ';';
		}

		echo 'data-dependency="' . esc_attr( $data ) . '"';
	}

	/**
	 * Get dependency class.
	 *
	 * @since 1.0.0
	 */
	public function dependency_class( $requires = array() ) {
		if ( ! $requires && isset( $this->args['requires'] ) ) {
			$requires = $this->args['requires'];
		}

		if ( ! $requires ) {
			return '';
		}

		$shown = true;

		foreach ( $this->args['requires'] as $dependency ) {
			if ( $shown == false ) {
				continue;
			}

			$parent_value = isset( $this->options[ $dependency['key'] ] ) ? $this->options[ $dependency['key'] ] : null;

			switch ( $dependency['compare'] ) {
				case 'equals':
					if ( ! is_null( $parent_value ) ) {
						if ( is_array( $dependency['value'] ) ) {
							$shown = in_array( $parent_value, $dependency['value'] );
						} else {
							$shown = $parent_value == $dependency['value'];
						}
					}
					break;
				case 'not_equals':
					if ( ! is_null( $parent_value ) ) {
						if ( is_array( $dependency['value'] ) ) {
							$shown = ! in_array( $parent_value, $dependency['value'] );
						} else {
							$shown = $parent_value != $dependency['value'];
						}
					}
					break;
			}
		}

		return ( $shown ) ? 'xts-shown' : 'xts-hidden';
	}

	/**
	 * After the control output.
	 *
	 * @since 1.0.0
	 */
	public function after() {
		?>
				<?php if ( isset( $this->args['description'] ) && ! empty( $this->args['description'] ) ) : ?>
					<p class="xts-field-description"><?php echo $this->args['description']; // phpcs:ignore ?></p>
				<?php endif; ?>
			</div>
		<?php
	}

	/**
	 * Get input name for form tags like input, textarea etc.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $subkey Subkey for array fields.
	 * @param bool $subkey2 Subkey for array fields. Second level.
	 * @param bool $subkey3 Subkey for array fields. Third level.
	 *
	 * @return string input field name.
	 */
	public function get_input_name( $subkey = false, $subkey2 = false, $subkey3 = false ) {
		$name = 'xts-' . $this->opt_name . '-options';

		$name .= '[' . $this->args['id'] . ']';

		if ( 'metabox' === $this->_type ) {
			$name = $this->args['id'];
		}

		if ( false !== $subkey ) {
			$name .= '[' . $subkey . ']';
		}

		if ( false !== $subkey2 ) {
			$name .= '[' . $subkey2 . ']';
		}

		if ( false !== $subkey3 ) {
			$name .= '[' . $subkey3 . ']';
		}

		return $name;
	}

	/**
	 * Get field value from options array or from post meta data.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $subkey Subkey for array fields.
	 *
	 * @return mixed Field value.
	 */
	public function get_field_value( $subkey = false ) {
		$val = '';

		$object = $this->_post ? $this->_post : $this->_term;

		if ( 'metabox' === $this->_type && ! is_null( $object ) ) {
			$object_id = $this->_post ? $this->_post->ID : $this->_term->term_id;
			$val       = get_metadata( $this->_object, $object_id, $this->get_input_name(), true );
		} elseif ( false !== $this->_presets ) {
			foreach ( $this->_presets as $preset_id ) {
				if ( isset( $this->options[ $preset_id ] ) && isset( $this->options[ $preset_id ][ $this->args['id'] ] ) ) {
					$val = $this->options[ $preset_id ][ $this->args['id'] ];
				}
			}

			if ( empty( $val ) && '0' !== $val ) {
				$val = $this->options[ $this->args['id'] ];
			}
		} elseif ( isset( $this->options[ $this->args['id'] ] ) ) {
			$val = $this->options[ $this->args['id'] ];
		}

		// Single metadata value, or array of values. If the $meta_type or $object_id parameters are invalid, false is returned. If the meta value isn't set, an empty string or array is returned, respectively.
		if ( 'metabox' === $this->_type && empty( $val ) && '0' !== $val ) {
			$val = isset( $this->args['default'] ) ? $this->args['default'] : '';
		}

		$val = $this->validate( $val );

		if ( $subkey ) {
			return isset( $val[ $subkey ] ) ? $val[ $subkey ] : '';
		}

		if ( isset( $val['{{index}}'] ) ) {
			unset( $val['{{index}}'] );
		}

		return $val;
	}

	public function get_default_value( $value = '' ) {
		if ( isset( $this->args['default'] ) ) {
			$value = $this->args['default'];
		} elseif ( ! empty( $this->args['devices'] ) && function_exists( 'woodmart_compress' ) ) {
			$value = woodmart_compress( wp_json_encode( array( 'devices' => $this->args['devices'] ) ) );
		}

		return $value;
	}

	/**
	 * Get field options array. For select or buttons set field type.
	 *
	 * @since 1.0.0
	 *
	 * @return array Field options array.
	 */
	public function get_field_options() {
		if ( ! isset( $this->args['options'] ) ) {
			return array();
		}

		return $this->args['options'];
	}

	/**
	 * Enqueue required scripts and styles for controls.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {}

	/**
	 * Output field's css code on frontend based on the control and its value.
	 *
	 * @since 1.0.0
	 */
	public function css_output() {
		if ( empty( $this->args['selectors'] ) || ( ! empty( $this->args['generate_zero'] ) && '' === $this->get_field_value() ) || ( empty( $this->args['generate_zero'] ) && ! $this->get_field_value() ) || $this->check_is_requires_css() ) {
			return array();
		}

		$output_css = array();
		$device     = ! empty( $this->args['css_device'] ) ? $this->args['css_device'] : 'desktop';

		foreach ( $this->args['selectors'] as $selector => $css_data ) {
			foreach ( $css_data as $css ) {
				$output_css[ $selector ][] = str_replace( '{{VALUE}}', $this->get_field_value(), $css ) . "\n";
			}
		}

		return array(
			$device => $output_css,
		);
	}

	public function check_is_requires_css() {
		if ( ! empty( $this->args['requires'] ) ) {
			foreach ( $this->args['requires'] as $require ) {
				if ( isset( $this->options[ $require['key'] ] ) ) {
					if ( 'equals' === $require['compare'] && ( ( is_array( $require['value'] ) && ! in_array( $this->options[ $require['key'] ], $require['value'], true ) ) || ( ! is_array( $require['value'] ) && $this->options[ $require['key'] ] !== $require['value'] ) ) ) {
						return true;
					} elseif ( 'not_equals' === $require['compare'] && ( ( is_array( $require['value'] ) && in_array( $this->options[ $require['key'] ], $require['value'], true ) ) || ( ! is_array( $require['value'] ) && $this->options[ $require['key'] ] === $require['value'] ) ) ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Sanitize field and its value before saving.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value Field value string.
	 *
	 * @return mixed.
	 */
	public function sanitize( $value ) {
		$sanitization = new Sanitize( $this, $value );

		return $sanitization->sanitize();
	}
}
