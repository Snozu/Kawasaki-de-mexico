<?php
/**
 * Sanitize fields values before save
 *
 * @package xts
 */

namespace XTS\Admin\Modules\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Sanitization class for fields
 */
class Sanitize {
	/**
	 * Field class
	 *
	 * @var Field
	 */
	private $_field;

	/**
	 * Initial field value
	 *
	 * @var Field
	 */
	private $_value;

	/**
	 * Class contructor
	 *
	 * @since 1.0.0
	 *
	 * @param object $field Field object.
	 * @param string $value field value.
	 */
	public function __construct( $field, $value ) {
		$this->_field = $field;
		$this->_value = $value;
	}

	/**
	 * Run field value sanitization.
	 *
	 * @since 1.0.0
	 *
	 * @return sanitized value
	 */
	public function sanitize() {

		$val = $this->_value;

		switch ( $this->_field->args['type'] ) {
			case 'typography':
				if ( is_array( $val ) && ! isset( $val[0] ) ) {
					$val = array( $val );
				}
				break;

			case 'switcher':
				if ( 'yes' === $val ) {
					$val = '1';
				}
				break;

			case 'background':
				if ( is_array( $val ) ) {
					if ( isset( $val['background-color'] ) && ! isset( $val['color'] ) ) {
						$val['color'] = $val['background-color'];
						unset( $val['background-color'] );
					}

					if ( isset( $val['background-repeat'] ) && ! isset( $val['repeat'] ) ) {
						$val['repeat'] = $val['background-repeat'];
						unset( $val['background-repeat'] );
					}

					if ( isset( $val['background-size'] ) && ! isset( $val['size'] ) ) {
						$val['size'] = $val['background-size'];
						unset( $val['background-size'] );
					}

					if ( isset( $val['background-attachment'] ) && ! isset( $val['attachment'] ) ) {
						$val['attachment'] = $val['background-attachment'];
						unset( $val['background-attachment'] );
					}

					if ( isset( $val['background-position'] ) && ! isset( $val['position'] ) ) {
						$val['position'] = $val['background-position'];
						unset( $val['background-position'] );
					}

					if ( isset( $val['background-image'] ) && ! isset( $val['url'] ) ) {
						$val['url'] = $val['background-image'];
						unset( $val['background-image'] );
					}
				}
				break;

			case 'custom_fonts':
			case 'upload_icons':
				// TODO: sanitize complex array.
				break;

			case 'textarea':
				$val = wp_kses_post( $val );

				break;

			case 'editor':
				break;

			case 'color':
				if ( ! is_array( $val ) && strlen( $val ) == 7 && ( ! isset( $this->_field->args['data_type'] ) || $this->_field->args['data_type'] != 'hex' ) ) {
					$val = array( 'idle' => $val );
				}
				break;

			case 'select_with_table':
				if ( isset( $val['{{index}}'] ) ) {
					unset( $val['{{index}}'] );
				}

				if ( $val ) {
					foreach ( $val as $id => $data ) {
						if ( empty( $data['id'] ) ) {
							unset( $val[ $id ] );
						}
					}
				}

				break;

			case 'text_input':
				if ( ! empty( $this->_field->args['sanitize'] ) && 'slug' === $this->_field->args['sanitize'] ) {
					$val = strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '_', $val ) ) );
				} elseif ( ! empty( $this->_field->args['attributes']['type'] ) && 'url' === $this->_field->args['attributes']['type'] ) {
					$val = esc_url( $val );
				} else {
					$val = sanitize_text_field( $val );
				}

				break;
			case 'discount_rules':
			case 'conditions':
				array_walk_recursive( $val, 'sanitize_text_field' );

				break;
			case 'timetable':
				foreach ( $val as $key => $dates ) {
					foreach ( $dates as $meta_key => $meta_value ) {
						switch ( $meta_key ) {
							case 'date_type':
							case 'iteration':
								$val[ $key ][ $meta_key ] = sanitize_text_field( $meta_value );
								break;
							case 'single_day':
							case 'first_day':
							case 'last_day':
								$pattern = '/^\d{4}-\d{2}-\d{2}$/';

								$val[ $key ][ $meta_key ] = preg_match( $pattern, $meta_value ) ? sanitize_text_field( $meta_value ) : '';
								break;
							default:
								$val[ $key ][ $meta_key ] = '';
								break;
						}
					}
				}

				break;
			default:
				$val = is_array( $val ) ? array_map( 'sanitize_text_field', $val ) : sanitize_text_field( $val );
				break;
		}

		return $val;
	}
}
