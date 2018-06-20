<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Spacing extends Kirki_Field_Dimensions {

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {

		$default_args = array(
			'controls' => array(
				'top'    => ( isset( $this->default['top'] ) ),
				'bottom' => ( isset( $this->default['top'] ) ),
				'left'   => ( isset( $this->default['top'] ) ),
				'right'  => ( isset( $this->default['top'] ) ),
			),
			'labels'   => array(
				'top'    => esc_attr__( 'Top', 'fundament_wp' ),
				'bottom' => esc_attr__( 'Bottom', 'fundament_wp' ),
				'left'   => esc_attr__( 'Left', 'fundament_wp' ),
				'right'  => esc_attr__( 'Right', 'fundament_wp' ),
			),
		);

		$this->choices = wp_parse_args( $this->choices, $default_args );

	}
}
