<?php
/**
 * WPObject Type - Product_Attribute_Type
 *
 * @package \WPGraphQL\Extensions\WooCommerce\Type\WPObject
 * @since   0.0.1
 */

namespace WPGraphQL\Extensions\WooCommerce\Type\WPObject;

use WPGraphQL\Extensions\WooCommerce\Data\Factory;
use WPGraphQL\Data\DataSource;
use GraphQLRelay\Relay;

/**
 * Class Product_Attribute_Type
 */
class Product_Attribute_Type {
	/**
	 * Registers type
	 */
	public static function register() {
		register_graphql_object_type(
			'ProductAttribute',
			array(
				'description' => __( 'A product attribute object', 'wp-graphql-woocommerce' ),
				'fields'      => array(
					'attributeId' => array(
						'type'        => array( 'non_null' => 'Int' ),
						'description' => __( 'Attribute ID', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							return ! empty( $attribute ) ? $attribute->get_id() : null;
						},
					),
					'name'        => array(
						'type'        => array( 'non_null' => 'String' ),
						'description' => __( 'Attribute name', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							return ! empty( $attribute ) ? $attribute->get_name() : null;
						},
					),
					'options'     => array(
						'type'        => array( 'list_of' => 'String' ),
						'description' => __( 'Attribute options', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							if ( empty( $attribute ) ) {
								return null;
							}
							if ( ! $attribute->is_taxonomy() || ! taxonomy_exists( $attribute->get_name() ) ) {
								return null;
							}
							$options = array();
							foreach ( $attribute->get_options() as $option ) {
								$options[] = get_term_by( 'id', $option, $attribute->get_name() )->name;
							}
							return $options;
						},
					),
					'position'    => array(
						'type'        => array( 'non_null' => 'Int' ),
						'description' => __( 'Attribute position', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							return ! empty( $attribute ) ? $attribute->get_position() : null;
						},
					),
					'visible'     => array(
						'type'        => array( 'non_null' => 'Boolean' ),
						'description' => __( 'Is attribute visible', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							return ! empty( $attribute ) ? $attribute->get_visible() : null;
						},
					),
					'variation'   => array(
						'type'        => array( 'non_null' => 'Boolean' ),
						'description' => __( 'Is attribute on product variation', 'wp-graphql-woocommerce' ),
						'resolve'     => function ( $attribute ) {
							return ! empty( $attribute ) ? $attribute->get_variation() : null;
						},
					),
				),
			)
		);
	}
}
