<?php
/**
 * Mutation - createOrder
 *
 * Registers mutation for creating an order.
 *
 * @package WPGraphQL\Extensions\WooCommerce\Mutation
 * @since 0.2.0
 */

namespace WPGraphQL\Extensions\WooCommerce\Mutation;

use GraphQL\Error\UserError;
use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\Extensions\WooCommerce\Data\Mutation\Order_Mutation;
use WPGraphQL\Extensions\WooCommerce\Model\Order;

/**
 * Class Order_Create
 */
class Order_Create {
	/**
	 * Registers mutation
	 */
	public static function register_mutation() {
		register_graphql_mutation(
			'createOrder',
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
		$input_fields = array(
			'parentId'           => array(
				'type'        => 'Integer',
				'description' => __( 'Parent order ID.', 'wp-graphql-woocommerce' ),
			),
			'currency'           => array(
				'type'        => 'String',
				'description' => __( 'Currency the order was created with, in ISO format.', 'wp-graphql-woocommerce' ),
			),
			'customerId'         => array(
				'type'        => array( 'non_null' => 'Int' ),
				'description' => __( 'Order customer ID', 'wp-graphql-woocommerce' ),
			),
			'customerNote'       => array(
				'type'        => 'String',
				'description' => __( 'Note left by customer during checkout.', 'wp-graphql-woocommerce' ),
			),
			'coupons'            => array(
				'type'        => array( 'list_of' => 'String' ),
				'description' => __( 'Coupons codes to be applied to order', 'wp-graphql-woocommerce' ),
			),
			'status'             => array(
				'type'        => 'OrderStatusEnum',
				'description' => __( 'Order status' ),
			),
			'paymentMethod'      => array(
				'type'        => 'String',
				'description' => __( 'Payment method ID.', 'woocommerce' ),
			),
			'paymentMethodTitle' => array(
				'type'        => 'String',
				'description' => __( 'Payment method title.', 'woocommerce' ),
			),
			'transactionId'      => array(
				'type'        => 'String',
				'description' => __( 'Order transaction ID', 'wp-graphql-woocommerce' ),
			),
			'billing'            => array(
				'type'        => 'CustomerAddressInput',
				'description' => __( 'Order billing address', 'wp-graphql-woocommerce' ),
			),
			'shipping'           => array(
				'type'        => 'CustomerAddressInput',
				'description' => __( 'Order shipping address', 'wp-graphql-woocommerce' ),
			),
			'lineItems'          => array(
				'type'        => array( 'list_of' => 'LineItemInput' ),
				'description' => __( 'Order line items', 'wp-graphql-woocommerce' ),
			),
			'shippingLines'      => array(
				'type'        => array( 'list_of' => 'ShippingLineInput' ),
				'description' => __( 'Order shipping lines', 'wp-graphql-woocommerce' ),
			),
			'feeLines'           => array(
				'type'        => array( 'list_of' => 'FeeLineInput' ),
				'description' => __( 'Order shipping lines', 'wp-graphql-woocommerce' ),
			),
			'metaData'           => array(
				'type'        => array( 'list_of' => 'MetaDataInput' ),
				'description' => __( 'Order meta data', 'wp-graphql-woocommerce' ),
			),
			'isPaid'             => array(
				'type'        => 'Boolean',
				'description' => __( 'Define if the order is paid. It will set the status to processing and reduce stock items.', 'wp-graphql-woocommerce' ),
			),
		);

		return $input_fields;
	}

	/**
	 * Defines the mutation output field configuration
	 *
	 * @return array
	 */
	public static function get_output_fields() {
		return array(
			'order' => array(
				'type'    => 'Order',
				'resolve' => function( $payload ) {
					return new Order( $payload['id'] );
				},
			),
		);
	}

	/**
	 * Defines the mutation data modification closure.
	 *
	 * @return callable
	 */
	public static function mutate_and_get_payload() {
		return function( $input, AppContext $context, ResolveInfo $info ) {
			$post_type_object = get_post_type_object( 'shop_order' );

			if ( ! current_user_can( $post_type_object->cap->create_posts ) ) {
				throw new UserError( __( 'Sorry, you are not allowed to create a new order.', 'wp-graphql-woocommerce' ) );
			}
			// Prepare order prop data.
			$props = Order_Mutation::prepare_props( $input, $context, $info );
			$order = null;
			try {
				$order = Order_Mutation::prepare_order_instance( $props, $context, $info );

				if ( is_wp_error( $order ) ) {
					throw new UserError( __( 'Sorry, there was a problem initializing the order.', 'wp-graphql-woocommerce' ) );
				}

				// Make sure gateways are loaded so hooks from gateways fire on save/create.
				WC()->payment_gateways();

				// Validate customer ID.
				if ( empty( $input['customerId'] ) ) {
					throw new UserError( __( 'No customer ID provided.', 'wp-graphql-woocommerce' ) );
				} elseif ( ! Order_Mutation::validate_customer( $input ) ) {
					throw new UserError( __( 'Customer ID is invalid.', 'wp-graphql-woocommerce' ) );
				}

				$order->set_created_via( 'graphql-api' );
				$order->set_prices_include_tax( 'yes' === get_option( 'woocommerce_prices_include_tax' ) );
				$order->calculate_totals();

				// Apply coupons.
				if ( ! empty( $input['coupons'] ) ) {
					Order_Mutation::apply_coupons( $input['coupons'], $order );
				}

				// Set status.
				if ( ! empty( $input['status'] ) ) {
					$order->set_status( $input['status'] );
				}

				\add_action(
					'woocommerce_before_order_item_object_save',
					function( $item ) {
						\codecept_debug( 'ITEM SAVED' );
					}
				);

				\add_action(
					'woocommerce_before_order_object_save',
					function( $item ) {
						\codecept_debug( 'ORDER SAVED' );
						//\codecept_debug( $item->get_items() );
					}
				);

				\add_action(
					'woocommerce_new_order',
					function( $id ) {
						\codecept_debug( "ORDER {$id} CREATED" );
					}
				);

				$order->apply_changes();
				$order->save();

				// Actions for after the order is saved.
				if ( true === $input['isPaid'] ) {
					$order->payment_complete(
						! empty( $input['transactionId'] ) ?
							$input['transactionId']
							: ''
					);
				}

				return array( 'id' => $order->get_id() );
			} catch ( \Exception $e ) {
				Order_Mutation::purge( $order, $creating );
				return new UserError( $e->getMessage() );
			}
		};
	}
}
