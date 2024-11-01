<?php
namespace WPMN\Shortcodes;

class Margin_Notes extends Shortcode {

	/**
	 * Shortcode tag
	 */
	protected $tag = 'margin_notes';

	/**
	 * List of supported attributes and their defaults
	 *
	 * @var array
	 */
	protected $defaults = array(
		'tag' => 'span',
		'link' => '',
		'desc' => ''
	);

	/**
	 * Display shortcode content
	 *
	 * @param array $attributes
	 * @return bool|string
	 */
	public function render( $attributes = array(), $content = '' ) {
		if ( empty( $content ) || ! isset( $attributes['desc'] ) ) {
			return '';
		}
		$attr = $this->attributes( $attributes );

		// Create the HTML output
		$output = sprintf( '<%1$s %4$s class="margin_notes" desc="%2$s">%3$s</%1$s>',
			esc_attr( $attr['tag'] ),
			esc_html( $attr['desc'] ),
			esc_html( $content ),
			( $attr['tag'] === 'a' && ! empty( $attr['link'] ) ) ? 'href=' . esc_url( $attr['link'] ) : ''
		);

		return $output;
	}

	public function add() {
		add_shortcode( $this->tag, array( $this, 'render' ) );
		if ( function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			$this->add_shortcake_support();
		}
	}

	protected function add_shortcake_support() {

		shortcode_ui_register_for_shortcode(
			$this->tag,
			array(

				// Display label. String. Required.
				'label' => __( 'Margin Notes', WPMN_TXTDOMAIN ),

				// Icon/image for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
				'listItemImage' => 'dashicons-format-aside',

				// Available shortcode attributes and default values. Required. Array.
				// Attribute model expects 'attr', 'type' and 'label'
				// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
				'attrs' => array(
					array(
						'label'       => __( 'Margin Note', WPMN_TXTDOMAIN ),
						'attr'        => 'desc',
						'type' => 'textarea',
						'description' => __( 'The text of the margin note', WPMN_TXTDOMAIN ),
					),
					array(
						'label'       => __( 'HTML Tag', WPMN_TXTDOMAIN ),
						'attr'        => 'tag',
						'type' => 'select',
						'options' => array(
							'span' => '<span>',
							'em' => '<em>',
							'strong' => '<strong>',
							'a' => '<a>',
						),
						'description' => __( 'Optional (<pre><span></pre> by default)', WPMN_TXTDOMAIN ),
					),
					array(
						'label'       => __( 'Link', WPMN_TXTDOMAIN ),
						'attr'        => 'link',
						'type' => 'url',
						'description' => __( 'The url of the link if you choose <a> tag', WPMN_TXTDOMAIN ),
					),
				),
				'inner_content' => array(
					'label' => __( 'Text', WPMN_TXTDOMAIN ),
				),
			)
		);
	}

}