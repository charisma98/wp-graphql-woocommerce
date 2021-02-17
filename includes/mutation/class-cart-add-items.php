<?php
/**
 * Mutation - addCartItems
 *
 * Registers mutation for adding multiple items to the cart.
 *
 * @package WPGraphQL\WooCommerce\Mutation
 * @since 0.7.0
 */

namespace WPGraphQL\WooCommerce\Mutation;

use GraphQL\Error\UserError;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\WooCommerce\Data\Mutation\Cart_Mutation;

/**
 * Class - Cart_Add_Items
 */
class Cart_Add_Items {
	/**
	 * Registers mutation
	 */
	public static function register_mutation() {
		register_graphql_mutation(
			'addCartItems',
			array(
				'inputFields'         => self::get_input_fields(),
				'outputFields'        => self::get_output_fields(),
				'mutateAndGetPayload' => self::mutate_and_get_payload(),
			)
		);
	}

	/**
	 * Defines the mutation input field configuration
	 *
	 * @return array
	 */
	public static function get_input_fields() {
		return array(
			'items' => array(
				'type'        => array( 'list_of' => 'CartItemInput' ),
				'description' => __( 'Cart items to be added', 'wp-graphql-woocommerce' ),
			),
		);
	}

	/**
	 * Defines the mutation output field configuration
	 *
	 * @return array
	 */
	public static function get_output_fields() {
		return array(
			'added' => array(
				'type'    => array( 'list_of' => 'CartItem' ),
				'resolve' => function ( $payload ) {
					$items = array();
					foreach ( $payload['added'] as $key ) {
						$items[] = \WC()->cart->get_cart_item( $key );
					}

					return $items;
				},
			),
			'cart'     => Cart_Mutation::get_cart_field( true ),
		);
	}

	/**
	 * Defines the mutation data modification closure.
	 *
	 * @return callable
	 */
	public static function mutate_and_get_payload() {
		return function( $input, AppContext $context, ResolveInfo $info ) {
			Cart_Mutation::check_session_token();

			// Throw error, if no cart item data provided.
			if ( empty( $input['items'] ) ) {
				throw new UserError( __( 'No cart item data provided', 'wp-graphql-woocommerce') );
			}

			// Validate cart item input.
			$added = array();
			$failure = array();
			foreach( $input['items'] as $cart_item_data ) {
				try {
					// Prepare args for "add_to_cart" from input data.
					$cart_item_args = Cart_Mutation::prepare_cart_item( $cart_item_data, $context, $info );

					// Add item to cart and get cart item key.
					$key = \WC()->cart->add_to_cart( ...$cart_item_args );

					// If cart item key valid, add to payload and continue to next item.
					if ( false !== $key ) {
						$added[] = $key;
						continue;
					}

					// Else capture errors.
					$notices = \WC()->session->get( 'wc_notices' );
					if ( ! empty( $notices['error'] ) ) {
						$reasons = implode( ' ', array_column( $notices['error'], 'notice' ) );
						\wc_clear_notices();

						$failure[] = compact( 'cart_item_data', 'reasons' );
					} else {
						$reason   = __( 'Failed to add cart item. Please check input.', 'wp-graphql-woocommerce' );

						$failure[] = compact( 'cart_item_data', 'reason' );
					}
				} catch ( \Exception $e ) {
					// Get thrown error message.
					$reason = $e->getMessage();

					// Capture error.
					$failure[] = compact( 'cart_item_data', 'reason' );
				}
			}

			// Log captured errors.
			if ( ! empty( $failure ) ) {
				graphql_debug( $failure, [ 'type' => 'INVALID_CART_ITEMS' ] );
			}

			// Throw error, if no items added.
			if ( empty( $added ) ) {
				throw new UserError( __( 'Failed to add any cart items. Please check input.', 'wp-graphql-woocommerce' ) );
			}

			// Return payload.
			return compact( 'added' );
		};
	}
}
